<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Services\CustomerCheckoutService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PaymentController extends Controller
{
    public function __construct(private readonly CustomerCheckoutService $checkoutService)
    {
    }

    public function createOrder(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'currency' => 'nullable|string|max:10',
            'address_id' => 'required|exists:user_addresses,id',
            'contact' => 'nullable|string|max:20',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'order_id' => 'nullable',
        ]);

        $user = $request->user();
        $address = $user->addresses()->find($validated['address_id']);

        if (! $address) {
            return response()->json(['status' => false, 'message' => 'Selected address is invalid'], 422);
        }

        try {
            [$order, $gatewayOrderId] = DB::transaction(function () use ($validated, $user, $address) {
                $order = ! empty($validated['order_id'])
                    ? $this->resolveUserOrder($user->id, $validated['order_id'], ['payments'])
                    : $this->checkoutService->createPendingOrderFromCart($user, $address, [
                        'status' => 'pending',
                        'payment_status' => 'unpaid',
                    ]);

                $gatewayOrderId = $this->checkoutService->generateGatewayOrderId();

                Payment::create([
                    'order_id' => $order->id,
                    'payment_method' => 'razorpay',
                    'amount' => (float) $validated['amount'],
                    'currency' => $validated['currency'] ?? CustomerCheckoutService::CURRENCY,
                    'gateway_order_id' => $gatewayOrderId,
                    'status' => 'initiated',
                    'gateway_payload' => [
                        'contact' => $validated['contact'] ?? $user->delivery_phone ?? $user->phone,
                        'name' => $validated['name'] ?? $user->name,
                        'email' => $validated['email'] ?? $user->email,
                        'address_id' => $address->id,
                    ],
                ]);

                return [$order->fresh(['payments']), $gatewayOrderId];
            });
        } catch (ValidationException $exception) {
            return response()->json(['status' => false, 'errors' => $exception->errors()], 422);
        }

        return response()->json([
            'status' => true,
            'data' => [
                'id' => $gatewayOrderId,
                'amount' => round((float) $validated['amount'], 2),
                'currency' => $validated['currency'] ?? CustomerCheckoutService::CURRENCY,
                'order_id' => $order->order_number,
            ],
        ]);
    }

    public function verify(Request $request)
    {
        $validated = $request->validate([
            'razorpay_order_id' => 'required|string',
            'razorpay_payment_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        $payment = Payment::with(['order.user', 'order.items.variant.product', 'order.address', 'order.payments'])
            ->where('gateway_order_id', $validated['razorpay_order_id'])
            ->firstOrFail();

        DB::transaction(function () use ($payment, $validated) {
            $payment->update([
                'transaction_id' => $validated['razorpay_payment_id'],
                'status' => 'success',
                'failure_code' => null,
                'failure_reason' => null,
                'paid_at' => now(),
                'gateway_payload' => array_merge($payment->gateway_payload ?? [], [
                    'razorpay_signature' => $validated['razorpay_signature'],
                    'verified_at' => now()->toISOString(),
                ]),
            ]);

            $order = $payment->order;
            $order->update([
                'payment_status' => 'paid',
                'status' => 'confirmed',
                'tracking_id' => $order->tracking_id ?: $this->checkoutService->generateTrackingId(),
                'delivery_date' => $order->delivery_date ?: now()->addDays(4)->toDateString(),
            ]);

            $this->checkoutService->clearCart($order->user);
        });

        return response()->json([
            'status' => true,
            'message' => 'Payment verified',
        ]);
    }

    public function webhook(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transaction_id' => 'required|string',
            'status' => 'required|in:success,failed,refunded',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $payment = Payment::where('transaction_id', $request->transaction_id)->firstOrFail();
        $payment->update([
            'status' => $request->status,
            'gateway_payload' => $request->all(),
            'paid_at' => $request->status === 'success' ? now() : $payment->paid_at,
        ]);

        $this->syncOrderFromPayment($payment->order, $payment);

        return response()->json(['status' => true, 'message' => 'Webhook processed']);
    }

    public function adminIndex(Request $request)
    {
        $payments = Payment::with(['order.user'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = $request->q;
                $query->where(function ($inner) use ($term) {
                    $inner->where('transaction_id', 'like', '%'.$term.'%')
                        ->orWhere('gateway_order_id', 'like', '%'.$term.'%')
                        ->orWhere('payment_method', 'like', '%'.$term.'%')
                        ->orWhereHas('order', function ($orderQuery) use ($term) {
                            $orderQuery->where('order_number', 'like', '%'.$term.'%')
                                ->orWhereHas('user', function ($userQuery) use ($term) {
                                    $userQuery->where('name', 'like', '%'.$term.'%')
                                        ->orWhere('email', 'like', '%'.$term.'%');
                                });
                        });
                });
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->when($request->filled('payment_method'), fn ($query) => $query->where('payment_method', $request->payment_method))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return response()->json(['status' => true, 'data' => $payments]);
    }

    public function adminShow($id)
    {
        $payment = Payment::with(['order.user', 'order.address', 'order.items.variant.product'])->findOrFail($id);

        return response()->json(['status' => true, 'data' => $payment]);
    }

    public function adminUpdate(Request $request, $id)
    {
        $payment = Payment::with('order')->findOrFail($id);

        $validated = $request->validate([
            'payment_method' => 'required|string|max:100',
            'transaction_id' => 'nullable|string|max:255|unique:payments,transaction_id,'.$payment->id,
            'status' => 'required|in:initiated,success,failed,refunded',
            'gateway_payload' => 'nullable|array',
            'currency' => 'nullable|string|max:10',
            'gateway_order_id' => 'nullable|string|unique:payments,gateway_order_id,'.$payment->id,
            'failure_code' => 'nullable|string|max:255',
            'failure_reason' => 'nullable|string',
        ]);

        $payment->update([
            'payment_method' => $validated['payment_method'],
            'transaction_id' => $validated['transaction_id'] ?? null,
            'status' => $validated['status'],
            'currency' => $validated['currency'] ?? $payment->currency,
            'gateway_order_id' => $validated['gateway_order_id'] ?? $payment->gateway_order_id,
            'failure_code' => $validated['failure_code'] ?? $payment->failure_code,
            'failure_reason' => $validated['failure_reason'] ?? $payment->failure_reason,
            'gateway_payload' => $validated['gateway_payload'] ?? $payment->gateway_payload,
            'paid_at' => $validated['status'] === 'success' ? ($payment->paid_at ?? now()) : $payment->paid_at,
        ]);

        $this->syncOrderFromPayment($payment->order, $payment);

        return response()->json([
            'status' => true,
            'message' => 'Payment updated successfully',
            'data' => $payment->fresh(['order.user', 'order.items']),
        ]);
    }

    private function resolveUserOrder(int $userId, string|int $identifier, array $with = []): Order
    {
        return Order::with($with)
            ->where('user_id', $userId)
            ->where(function ($query) use ($identifier) {
                $query->where('order_number', $identifier);

                if (is_numeric($identifier)) {
                    $query->orWhere('id', (int) $identifier);
                }
            })
            ->firstOrFail();
    }

    private function syncOrderFromPayment(Order $order, Payment $payment): void
    {
        $statusMap = match ($payment->status) {
            'success' => [
                'payment_status' => 'paid',
                'status' => $order->status === 'pending' ? 'confirmed' : $order->status,
                'tracking_id' => $order->tracking_id ?: $this->checkoutService->generateTrackingId(),
                'delivery_date' => $order->delivery_date ?: now()->addDays(4)->toDateString(),
            ],
            'failed' => ['payment_status' => 'failed'],
            'refunded' => ['payment_status' => 'refunded'],
            default => ['payment_status' => 'unpaid'],
        };

        $order->update($statusMap);
    }
}
