<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'payment_method' => 'required|string|max:100',
            'transaction_id' => 'nullable|string|max:255|unique:payments,transaction_id',
            'status' => 'nullable|in:initiated,success,failed,refunded',
            'gateway_payload' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $order = Order::where('user_id', $request->user()->id)->with('payments')->findOrFail($request->order_id);
        $status = $request->status ?? 'initiated';

        if ($order->payment_status === 'paid' && in_array($status, ['initiated', 'success'], true)) {
            return response()->json(['status' => false, 'message' => 'Payment has already been completed for this order'], 422);
        }

        if ($order->payments()->whereIn('status', ['initiated', 'success'])->exists() && in_array($status, ['initiated', 'success'], true)) {
            return response()->json(['status' => false, 'message' => 'A payment attempt already exists for this order'], 422);
        }

        $payment = Payment::create([
            'order_id' => $order->id,
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'amount' => $order->total_amount,
            'status' => $status,
            'gateway_payload' => $request->gateway_payload,
            'paid_at' => $status === 'success' ? now() : null,
        ]);

        if ($status === 'success') {
            $order->update(['payment_status' => 'paid', 'status' => 'confirmed']);
        }

        if ($status === 'failed') {
            $order->update(['payment_status' => 'failed']);
        }

        return response()->json(['status' => true, 'message' => 'Payment recorded', 'data' => $payment], 201);
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

        $order = $payment->order;
        if ($request->status === 'success') {
            $order->update(['payment_status' => 'paid', 'status' => 'confirmed']);
        }
        if ($request->status === 'failed') {
            $order->update(['payment_status' => 'failed']);
        }
        if ($request->status === 'refunded') {
            $order->update(['payment_status' => 'refunded']);
        }

        return response()->json(['status' => true, 'message' => 'Webhook processed']);
    }

    public function show(Request $request, $orderId)
    {
        $order = Order::where('user_id', $request->user()->id)->findOrFail($orderId);

        return response()->json(['status' => true, 'data' => $order->payments()->latest()->get()]);
    }

    public function adminIndex(Request $request)
    {
        $payments = Payment::with(['order.user'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = $request->q;
                $query->where(function ($inner) use ($term) {
                    $inner->where('transaction_id', 'like', '%'.$term.'%')
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
        ]);

        $payment->update([
            'payment_method' => $validated['payment_method'],
            'transaction_id' => $validated['transaction_id'] ?? null,
            'status' => $validated['status'],
            'gateway_payload' => $validated['gateway_payload'] ?? $payment->gateway_payload,
            'paid_at' => $validated['status'] === 'success' ? ($payment->paid_at ?? now()) : $payment->paid_at,
        ]);

        $orderStatus = match ($validated['status']) {
            'success' => ['payment_status' => 'paid', 'status' => $payment->order->status === 'pending' ? 'confirmed' : $payment->order->status],
            'failed' => ['payment_status' => 'failed'],
            'refunded' => ['payment_status' => 'refunded'],
            default => ['payment_status' => 'unpaid'],
        };

        $payment->order->update($orderStatus);

        return response()->json([
            'status' => true,
            'message' => 'Payment updated successfully',
            'data' => $payment->fresh(['order.user', 'order.items']),
        ]);
    }
}
