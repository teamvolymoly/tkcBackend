<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Order;
use App\Services\CustomerCheckoutService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function __construct(private readonly CustomerCheckoutService $checkoutService)
    {
    }

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

        $summary = $this->checkoutService->checkoutSummary($user);

        if (empty($summary['items'])) {
            return response()->json(['status' => false, 'message' => 'Cart is empty'], 422);
        }

        $discount = 0;
        $coupon = null;

        if ($request->filled('coupon_code')) {
            $coupon = Coupon::where('code', $request->coupon_code)->where('is_active', true)->first();

            if (! $coupon) {
                return response()->json(['status' => false, 'message' => 'Invalid or expired coupon'], 422);
            }

            $validationError = $this->validateCouponForOrder($coupon, (float) $summary['total'], $user->id);

            if ($validationError) {
                return response()->json(['status' => false, 'message' => $validationError], 422);
            }

            $discount = $this->calculateDiscount($coupon, (float) $summary['total']);
        }

        $order = DB::transaction(function () use ($user, $address, $request, $coupon, $summary, $discount) {
            $order = $this->checkoutService->createPendingOrderFromCart($user, $address, [
                'coupon_code' => $coupon?->code,
                'discount_amount' => $discount,
                'total_amount' => max(0, (float) $summary['total'] - $discount),
                'notes' => $request->notes,
                'status' => 'confirmed',
                'payment_status' => 'unpaid',
            ]);

            if ($coupon) {
                CouponUsage::create([
                    'coupon_id' => $coupon->id,
                    'user_id' => $user->id,
                    'order_id' => $order->id,
                    'used_at' => now(),
                ]);
            }

            $this->checkoutService->clearCart($user);

            return $order->fresh(['items.variant.product', 'payments', 'address']);
        });

        return response()->json([
            'status' => true,
            'message' => 'Order created successfully',
            'data' => $this->checkoutService->buildOrderDetail($order),
        ], 201);
    }

    public function index(Request $request)
    {
        $limit = min(max((int) $request->integer('limit', 10), 1), 50);

        $orders = Order::with(['items', 'payments'])
            ->where('user_id', $request->user()->id)
            ->when($request->filled('status'), function ($query) use ($request) {
                $status = match (strtolower((string) $request->status)) {
                    'delivered' => 'delivered',
                    'in transit' => 'shipped',
                    'packed' => 'processing',
                    'confirmed' => 'confirmed',
                    'cancelled' => 'cancelled',
                    'pending' => 'pending',
                    default => strtolower((string) $request->status),
                };

                $query->where('status', $status);
            })
            ->when($request->filled('from'), fn ($query) => $query->whereDate('created_at', '>=', $request->from))
            ->when($request->filled('to'), fn ($query) => $query->whereDate('created_at', '<=', $request->to))
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($inner) use ($search) {
                    $inner->where('order_number', 'like', '%'.$search.'%')
                        ->orWhereHas('items', fn ($itemQuery) => $itemQuery->where('product_name', 'like', '%'.$search.'%'));
                });
            })
            ->latest()
            ->paginate($limit)
            ->withQueryString();

        return response()->json([
            'status' => true,
            'data' => [
                'items' => collect($orders->items())
                    ->map(fn (Order $order) => $this->checkoutService->buildOrderListItem($order))
                    ->values(),
                'pagination' => [
                    'page' => $orders->currentPage(),
                    'limit' => $orders->perPage(),
                    'total_items' => $orders->total(),
                    'total_pages' => $orders->lastPage(),
                ],
            ],
        ]);
    }

    public function show(Request $request, $id)
    {
        $order = $this->resolveUserOrder($request, $id, ['items.variant.product', 'payments', 'address']);

        return response()->json([
            'status' => true,
            'data' => $this->checkoutService->buildOrderDetail($order),
        ]);
    }

    public function cancel(Request $request, $id)
    {
        $order = $this->resolveUserOrder($request, $id);

        if (in_array($order->status, ['shipped', 'delivered', 'cancelled'], true)) {
            return response()->json(['status' => false, 'message' => 'Order cannot be cancelled'], 422);
        }

        $order->update([
            'status' => 'cancelled',
            'cancel_reason' => $request->input('reason'),
        ]);

        return response()->json(['status' => true, 'message' => 'Order cancelled']);
    }

    public function track(Request $request, $id)
    {
        $order = $this->resolveUserOrder($request, $id);

        return response()->json([
            'status' => true,
            'data' => [
                'order_id' => $order->order_number,
                'events' => $this->checkoutService->trackingEvents($order),
            ],
        ]);
    }

    public function requestReturn(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:1000',
            'items' => 'nullable|array',
        ]);

        $order = $this->resolveUserOrder($request, $id);

        if (! in_array($order->status, ['delivered', 'confirmed', 'processing', 'shipped'], true)) {
            return response()->json(['status' => false, 'message' => 'Return cannot be requested for this order'], 422);
        }

        $order->update([
            'return_reason' => $request->reason,
            'return_items' => $request->input('items', []),
            'return_requested_at' => now(),
        ]);

        return response()->json(['status' => true, 'message' => 'Return requested']);
    }

    private function resolveUserOrder(Request $request, string|int $identifier, array $with = [])
    {
        return Order::with($with)
            ->where('user_id', $request->user()->id)
            ->where(function ($query) use ($identifier) {
                $query->where('order_number', $identifier);

                if (is_numeric($identifier)) {
                    $query->orWhere('id', (int) $identifier);
                }
            })
            ->firstOrFail();
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
