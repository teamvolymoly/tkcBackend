<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address_id' => 'required|exists:user_addresses,id',
            'coupon_code' => 'nullable|string|exists:coupons,code',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $user = $request->user();
        $address = $user->addresses()->find($request->address_id);

        if (! $address) {
            return response()->json(['status' => false, 'message' => 'Selected address is invalid'], 422);
        }

        $cart = Cart::with('items.variant.product', 'items.variant.inventory')->firstOrCreate(['user_id' => $user->id]);

        if ($cart->items->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'Cart is empty'], 422);
        }

        foreach ($cart->items as $item) {
            $validationError = $this->validatePurchasableVariant($item->variant, (int) $item->quantity);

            if ($validationError) {
                return response()->json(['status' => false, 'message' => $validationError], 422);
            }
        }

        $subtotal = $cart->items->sum(function ($item) {
            return $item->quantity * $item->variant->price;
        });

        $discount = 0;
        $coupon = null;
        $shippingAmount = 0;

        if ($request->filled('coupon_code')) {
            $coupon = Coupon::where('code', $request->coupon_code)->where('is_active', true)->first();

            if (! $coupon) {
                return response()->json(['status' => false, 'message' => 'Invalid or expired coupon'], 422);
            }

            $validationError = $this->validateCouponForOrder($coupon, $subtotal, $user->id);

            if ($validationError) {
                return response()->json(['status' => false, 'message' => $validationError], 422);
            }

            $discount = $this->calculateDiscount($coupon, $subtotal);
        }

        $total = max(0, ($subtotal - $discount) + $shippingAmount);

        $order = DB::transaction(function () use ($user, $request, $cart, $subtotal, $discount, $shippingAmount, $total, $coupon) {
            $order = Order::create([
                'user_id' => $user->id,
                'address_id' => $request->address_id,
                'order_number' => 'ORD-'.now()->format('YmdHis').'-'.rand(1000, 9999),
                'subtotal' => $subtotal,
                'discount_amount' => $discount,
                'shipping_amount' => $shippingAmount,
                'total_amount' => $total,
                'coupon_code' => $coupon?->code,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'notes' => $request->notes,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->variant->product_id,
                    'variant_id' => $item->variant_id,
                    'product_name' => $item->variant->product->name,
                    'variant_name' => $item->variant->variant_name,
                    'price' => $item->variant->price,
                    'quantity' => $item->quantity,
                ]);
            }

            if ($coupon) {
                CouponUsage::create([
                    'coupon_id' => $coupon->id,
                    'user_id' => $user->id,
                    'order_id' => $order->id,
                    'used_at' => now(),
                ]);
            }

            $cart->items()->delete();

            return $order;
        });

        return response()->json([
            'status' => true,
            'message' => 'Order created successfully',
            'data' => $order->load('items.variant', 'address'),
        ], 201);
    }

    public function index(Request $request)
    {
        $orders = Order::with('items', 'payments')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(20);

        return response()->json(['status' => true, 'data' => $orders]);
    }

    public function show(Request $request, $id)
    {
        $order = Order::with('items.variant.product', 'payments', 'address')
            ->where('user_id', $request->user()->id)
            ->findOrFail($id);

        return response()->json(['status' => true, 'data' => $order]);
    }

    public function cancel(Request $request, $id)
    {
        $order = Order::where('user_id', $request->user()->id)->findOrFail($id);

        if (in_array($order->status, ['shipped', 'delivered', 'cancelled'], true)) {
            return response()->json(['status' => false, 'message' => 'Order cannot be cancelled'], 422);
        }

        $order->update(['status' => 'cancelled']);

        return response()->json(['status' => true, 'message' => 'Order cancelled', 'data' => $order]);
    }

    public function track(Request $request, $id)
    {
        $order = Order::where('user_id', $request->user()->id)->findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'status' => $order->status,
                'payment_status' => $order->payment_status,
                'updated_at' => $order->updated_at,
            ],
        ]);
    }

    private function validatePurchasableVariant(?ProductVariant $variant, int $quantity): ?string
    {
        if (! $variant) {
            return 'One or more cart items are no longer available';
        }

        if (! $variant->status || ! $variant->product || ! $variant->product->status) {
            return 'One or more cart items are inactive';
        }

        $availableStock = (int) ($variant->inventory->stock ?? $variant->stock ?? 0);

        if ($availableStock < $quantity) {
            return 'Requested quantity is not available for one or more cart items';
        }

        return null;
    }

    private function validateCouponForOrder(Coupon $coupon, float $subtotal, int $userId): ?string
    {
        if ($coupon->expiry_date && Carbon::today()->gt($coupon->expiry_date)) {
            return 'Invalid or expired coupon';
        }

        if ($coupon->min_order_amount && $subtotal < $coupon->min_order_amount) {
            return 'Order does not meet coupon minimum amount';
        }

        if ($coupon->required_completed_orders !== null) {
            $completedOrdersCount = $this->completedOrdersCount($userId);

            if ($completedOrdersCount < $coupon->required_completed_orders) {
                return 'Required completed orders not reached';
            }
        }

        if ($coupon->usage_limit !== null && $coupon->usages()->count() >= $coupon->usage_limit) {
            return 'Coupon usage limit reached';
        }

        if ($coupon->per_user_limit !== null) {
            $userUsageCount = $coupon->usages()->where('user_id', $userId)->count();

            if ($userUsageCount >= $coupon->per_user_limit) {
                return 'You have reached the coupon usage limit';
            }
        }

        return null;
    }

    private function calculateDiscount(Coupon $coupon, float $subtotal): float
    {
        $discount = $coupon->discount_type === 'percent'
            ? ($subtotal * $coupon->discount_value) / 100
            : min($subtotal, $coupon->discount_value);

        if ($coupon->max_discount) {
            $discount = min($discount, $coupon->max_discount);
        }

        return $discount;
    }

    private function completedOrdersCount(int $userId): int
    {
        return Order::where('user_id', $userId)
            ->whereIn('status', ['delivered', 'completed'])
            ->count();
    }
}
