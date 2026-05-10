<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use App\Models\UserAddress;
use App\Services\CustomerCheckoutService;
use App\Services\RazorpayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use RuntimeException;

class PaymentController extends Controller
{
    public function __construct(
        private readonly CustomerCheckoutService $checkoutService,
        private readonly RazorpayService $razorpayService,
    )
    {
    }

    public function createOrder(Request $request)
    {
        $validated = $request->validate([
            'currency' => 'nullable|string|max:10',
            'address_id' => 'required|exists:user_addresses,id',
            'contact' => 'nullable|string|max:20',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);

        $user = $request->user();
        $address = $user->addresses()->find($validated['address_id']);

        if (! $address) {
            return response()->json(['status' => false, 'message' => 'Selected address is invalid'], 422);
        }

        try {
            $checkout = $this->checkoutService->prepareCheckoutForPayment($user);
        } catch (ValidationException $exception) {
            return response()->json([
                'status' => false,
                'message' => collect($exception->errors())->flatten()->first() ?: 'Unable to create payment order.',
                'errors' => $exception->errors(),
            ], 422);
        }

        $summary = $checkout['summary'];
        $currency = $validated['currency'] ?? CustomerCheckoutService::CURRENCY;
        $amountInPaise = $this->toPaise((float) ($summary['final_total'] ?? 0));
        $receipt = 'PAY-'.strtoupper(bin2hex(random_bytes(4)));

        try {
            $gatewayOrder = $this->razorpayService->createOrder(
                $receipt,
                $amountInPaise,
                $currency,
                [
                    'user_id' => (string) $user->id,
                ]
            );
        } catch (RuntimeException $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage(),
            ], 422);
        }

        $payment = Payment::create([
            'order_id' => null,
            'payment_method' => 'razorpay',
            'amount' => (float) ($summary['final_total'] ?? 0),
            'currency' => $currency,
            'gateway_order_id' => $gatewayOrder['id'],
            'status' => 'initiated',
            'gateway_payload' => [
                'user_id' => $user->id,
                'contact' => $validated['contact'] ?? $user->delivery_phone ?? $user->phone,
                'name' => $validated['name'] ?? $user->name,
                'email' => $validated['email'] ?? $user->email,
                'address_id' => $address->id,
                'address_snapshot' => $this->snapshotAddress($address),
                'coupon_code' => $checkout['coupon']['code'] ?? null,
                'checkout' => [
                    'items' => $checkout['items'] ?? [],
                    'summary' => $summary,
                    'coupon' => $checkout['coupon'] ?? null,
                ],
                'razorpay_order' => $gatewayOrder,
            ],
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Payment attempt created',
            'data' => [
                'payment_attempt_id' => $payment->id,
                'razorpay_order_id' => $gatewayOrder['id'],
                'amount' => $amountInPaise,
                'currency' => $currency,
                'key' => $this->razorpayService->key(),
            ],
        ]);
    }

    public function success(Request $request, string $orderId)
    {
        $payment = $this->resolveUserPayment(
            $request->user()->id,
            $orderId,
            ['order.user', 'order.address', 'order.items.variant.product', 'order.payments']
        );

        if (! $payment->order) {
            return response()->json([
                'status' => false,
                'message' => 'Order is not available for this payment yet.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Payment success details fetched successfully.',
            'data' => $this->checkoutService->buildPaymentSuccess($payment->order),
        ]);
    }

    public function failed(Request $request, string $orderId)
    {
        $payment = $this->resolveUserPayment(
            $request->user()->id,
            $orderId,
            ['order.user', 'order.address', 'order.items.variant.product', 'order.payments']
        );

        return response()->json([
            'status' => true,
            'message' => 'Payment failure details fetched successfully.',
            'data' => $this->checkoutService->buildPaymentFailureFromAttempt($payment),
        ]);
    }

    public function verify(Request $request)
    {
        $validated = $request->validate([
            'payment_attempt_id' => 'required|integer',
            'razorpay_order_id' => 'required|string',
            'razorpay_payment_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        $payment = Payment::with(['order.user', 'order.items.variant.product', 'order.address', 'order.payments'])
            ->where('id', $validated['payment_attempt_id'])
            ->where('gateway_order_id', $validated['razorpay_order_id'])
            ->firstOrFail();

        if (! $this->razorpayService->verifyPaymentSignature(
            $validated['razorpay_order_id'],
            $validated['razorpay_payment_id'],
            $validated['razorpay_signature']
        )) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid Razorpay signature.',
            ], 422);
        }

        if ($payment->status === 'success') {
            return response()->json([
                'status' => true,
                'message' => 'Payment already verified and order already created',
                'data' => [
                    'order_id' => $payment->order?->order_number,
                    'payment_attempt_id' => $payment->id,
                    'payment_status' => 'Paid',
                ],
            ]);
        }

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

            $this->finalizeSuccessfulPayment($payment->fresh(['order.user', 'order.items.variant.product', 'order.address', 'order.payments']));
        });

        return response()->json([
            'status' => true,
            'message' => 'Payment verified and order created',
            'data' => [
                'order_id' => $payment->fresh('order')->order?->order_number,
                'payment_attempt_id' => $payment->id,
                'payment_status' => 'Paid',
            ],
        ]);
    }

    public function failure(Request $request)
    {
        $validated = $request->validate([
            'payment_attempt_id' => 'required|integer',
            'razorpay_order_id' => 'required|string',
            'razorpay_payment_id' => 'nullable|string',
            'code' => 'nullable|string|max:255',
            'reason' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $payment = Payment::with(['order'])
            ->where('id', $validated['payment_attempt_id'])
            ->where('gateway_order_id', $validated['razorpay_order_id'])
            ->firstOrFail();

        if ($payment->status === 'success') {
            return response()->json([
                'status' => false,
                'message' => 'Successful payments cannot be marked as failed.',
            ], 422);
        }

        $gatewayPayload = array_merge($payment->gateway_payload ?? [], [
            'failure' => [
                'code' => $validated['code'] ?? null,
                'reason' => $validated['reason'] ?? null,
                'description' => $validated['description'] ?? null,
                'payment_id' => $validated['razorpay_payment_id'] ?? null,
                'recorded_at' => now()->toISOString(),
            ],
        ]);

        $payment->update([
            'transaction_id' => $validated['razorpay_payment_id'] ?? $payment->transaction_id,
            'status' => 'failed',
            'failure_code' => $validated['code'] ?? $payment->failure_code,
            'failure_reason' => $validated['description'] ?? $validated['reason'] ?? $payment->failure_reason,
            'gateway_payload' => $gatewayPayload,
        ]);

        if ($payment->order) {
            $this->syncOrderFromPayment($payment->order, $payment);
        }

        return response()->json([
            'status' => true,
            'message' => 'Payment failure recorded',
            'data' => [
                'payment_attempt_id' => $payment->id,
                'payment_status' => 'Failed',
            ],
        ]);
    }

    public function webhook(Request $request)
    {
        if (! $this->razorpayService->verifyWebhookSignature($request->getContent(), $request->header('X-Razorpay-Signature'))) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid webhook signature.',
            ], 422);
        }

        $payload = $request->all();
        $event = (string) ($payload['event'] ?? '');
        $gatewayOrderId = data_get($payload, 'payload.payment.entity.order_id')
            ?? data_get($payload, 'payload.order.entity.id');
        $transactionId = data_get($payload, 'payload.payment.entity.id');
        $failureCode = data_get($payload, 'payload.payment.entity.error_code');
        $failureReason = data_get($payload, 'payload.payment.entity.error_description')
            ?? data_get($payload, 'payload.payment.entity.error_reason');

        if (! $gatewayOrderId) {
            return response()->json([
                'status' => false,
                'message' => 'Unable to resolve Razorpay order from webhook payload.',
            ], 422);
        }

        $payment = Payment::with(['order.user', 'order.items.variant.product', 'order.address', 'order.payments'])
            ->where('gateway_order_id', $gatewayOrderId)
            ->firstOrFail();

        $status = match ($event) {
            'payment.captured', 'order.paid' => 'success',
            'payment.failed' => 'failed',
            'refund.processed', 'payment.refunded' => 'refunded',
            default => null,
        };

        if (! $status) {
            return response()->json([
                'status' => true,
                'message' => 'Webhook acknowledged.',
            ]);
        }

        $payment->update([
            'transaction_id' => $transactionId ?: $payment->transaction_id,
            'status' => $status,
            'failure_code' => $status === 'failed' ? $failureCode : null,
            'failure_reason' => $status === 'failed' ? $failureReason : null,
            'gateway_payload' => $this->mergeWebhookPayload($payment, $payload, $status, $transactionId, $failureCode, $failureReason),
            'paid_at' => $status === 'success' ? ($payment->paid_at ?? now()) : $payment->paid_at,
        ]);

        if ($status === 'success') {
            DB::transaction(function () use ($payment) {
                $this->finalizeSuccessfulPayment($payment->fresh(['order.user', 'order.items.variant.product', 'order.address', 'order.payments']));
            });
        } elseif ($payment->order) {
            $this->syncOrderFromPayment($payment->order, $payment);
        }

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

        if ($validated['status'] === 'success') {
            DB::transaction(function () use ($payment) {
                $this->finalizeSuccessfulPayment($payment->fresh(['order.user', 'order.items.variant.product', 'order.address', 'order.payments']));
            });
        } elseif ($payment->order) {
            $this->syncOrderFromPayment($payment->order, $payment);
        }

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

    private function finalizeSuccessfulPayment(Payment $payment): void
    {
        if (! $payment->order) {
            $payment = $this->attachOrderToSuccessfulPayment($payment);
        }

        $order = $payment->order;

        $order->update([
            'payment_status' => 'paid',
            'status' => 'confirmed',
            'tracking_id' => $order->tracking_id ?: $this->checkoutService->generateTrackingId(),
            'delivery_date' => $order->delivery_date ?: now()->addDays(4)->toDateString(),
        ]);

        // Coupon is consumed only after a successful payment and is never restored on later cancellation.
        $this->checkoutService->recordCouponUsage($order);
        $this->checkoutService->clearAppliedCoupon($order->user);
        $this->checkoutService->clearCart($order->user);
    }

    private function toPaise(float $amount): int
    {
        return (int) round($amount * 100);
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

    private function resolveUserPayment(int $userId, string|int $identifier, array $with = []): Payment
    {
        $payment = Payment::with($with)
            ->where(function ($query) use ($identifier) {
                $query->where('gateway_order_id', $identifier)
                    ->orWhere('transaction_id', $identifier);

                if (is_numeric($identifier)) {
                    $query->orWhere('id', (int) $identifier);
                }
            })
            ->latest('id')
            ->first();

        if (! $payment) {
            $order = $this->resolveUserOrder($userId, (string) $identifier, ['payments']);
            $payment = $order->payments->sortByDesc('id')->first();

            abort_if(! $payment, 404);
        }

        $ownerId = $payment->order?->user_id ?? (int) data_get($payment->gateway_payload, 'user_id');

        abort_if($ownerId !== $userId, 404);

        return $payment;
    }

    private function attachOrderToSuccessfulPayment(Payment $payment): Payment
    {
        $payload = $payment->gateway_payload ?? [];
        $user = User::findOrFail((int) data_get($payload, 'user_id'));
        $address = $user->addresses()->find(data_get($payload, 'address_id'));
        $snapshot = $payload['checkout'] ?? [];

        $order = $this->checkoutService->createOrderFromCheckoutSnapshot($user, $address, $snapshot, [
            'coupon_code' => data_get($snapshot, 'coupon.code'),
            'discount_amount' => (float) data_get($snapshot, 'summary.discount_amount', 0),
            'total_amount' => (float) data_get($snapshot, 'summary.final_total', data_get($snapshot, 'summary.total', 0)),
            'status' => 'confirmed',
            'payment_status' => 'paid',
            'tracking_id' => $this->checkoutService->generateTrackingId(),
            'delivery_date' => now()->addDays(4)->toDateString(),
        ]);

        $payment->order()->associate($order);
        $payment->save();

        return $payment->fresh(['order.user', 'order.items.variant.product', 'order.address', 'order.payments']);
    }

    private function snapshotAddress(UserAddress $address): array
    {
        return [
            'label' => $address->label,
            'address_line1' => $address->address_line1,
            'address_line2' => $address->address_line2,
            'city' => $address->city,
            'state' => $address->state,
            'pincode' => $address->pincode,
            'country' => $address->country,
        ];
    }

    private function mergeWebhookPayload(
        Payment $payment,
        array $payload,
        string $status,
        ?string $transactionId,
        ?string $failureCode,
        ?string $failureReason
    ): array {
        return array_merge($payment->gateway_payload ?? [], [
            'webhook' => [
                'status' => $status,
                'payload' => $payload,
                'transaction_id' => $transactionId,
                'failure_code' => $failureCode,
                'failure_reason' => $failureReason,
                'received_at' => now()->toISOString(),
            ],
        ]);
    }
}
