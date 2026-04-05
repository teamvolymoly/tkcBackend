<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $coupons = $this->baseQuery($request)
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('expiry_date')->orWhere('expiry_date', '>=', Carbon::today());
            })
            ->get();

        return response()->json(['status' => true, 'data' => $coupons]);
    }

    public function adminIndex(Request $request)
    {
        $coupons = $this->baseQuery($request)
            ->paginate(20)
            ->withQueryString();

        return response()->json(['status' => true, 'data' => $coupons]);
    }

    public function show(Coupon $coupon)
    {
        return response()->json([
            'status' => true,
            'data' => $coupon->load(['usages.user:id,name,email', 'usages.order:id,order_number,total_amount']),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateCoupon($request);
        $coupon = Coupon::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Coupon created successfully',
            'data' => $coupon,
        ], 201);
    }

    public function update(Request $request, Coupon $coupon)
    {
        $validated = $this->validateCoupon($request, $coupon);
        $coupon->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Coupon updated successfully',
            'data' => $coupon->fresh(),
        ]);
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return response()->json([
            'status' => true,
            'message' => 'Coupon deleted successfully',
        ]);
    }

    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required|string|exists:coupons,code',
            'amount' => 'required|numeric|min:0',
        ]);

        $coupon = Coupon::where('code', $request->code)
            ->where('is_active', true)
            ->firstOrFail();

        $validationError = $this->validateCouponForAmount($coupon, (float) $request->amount, $request->user()?->id);

        if ($validationError) {
            return response()->json(['status' => false, 'message' => $validationError], 422);
        }

        $discount = $this->calculateDiscount($coupon, (float) $request->amount);
        $finalAmount = max(0, $request->amount - $discount);

        return response()->json([
            'status' => true,
            'data' => [
                'coupon' => $coupon,
                'discount' => round($discount, 2),
                'final_amount' => round($finalAmount, 2),
            ],
        ]);
    }

    private function baseQuery(Request $request)
    {
        return Coupon::query()
            ->when($request->filled('q'), function ($builder) use ($request) {
                $builder->where('code', 'like', '%'.$request->q.'%');
            })
            ->withCount('usages')
            ->latest();
    }

    private function validateCoupon(Request $request, ?Coupon $coupon = null): array
    {
        return $request->validate([
            'code' => ['required', 'string', 'max:255', Rule::unique('coupons', 'code')->ignore($coupon?->id)],
            'discount_type' => ['required', 'in:fixed,percent'],
            'discount_value' => ['required', 'numeric', 'min:0'],
            'min_order_amount' => ['nullable', 'numeric', 'min:0'],
            'max_discount' => ['nullable', 'numeric', 'min:0'],
            'expiry_date' => ['nullable', 'date'],
            'usage_limit' => ['nullable', 'integer', 'min:1'],
            'per_user_limit' => ['nullable', 'integer', 'min:1'],
            'required_completed_orders' => ['nullable', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }

    private function validateCouponForAmount(Coupon $coupon, float $amount, ?int $userId = null): ?string
    {
        if ($coupon->expiry_date && Carbon::today()->gt($coupon->expiry_date)) {
            return 'Coupon expired';
        }

        if ($coupon->min_order_amount && $amount < $coupon->min_order_amount) {
            return 'Minimum amount not met';
        }

        if ($coupon->required_completed_orders !== null) {
            if (! $userId) {
                return 'Login required for this coupon';
            }

            $completedOrdersCount = $this->completedOrdersCount($userId);

            if ($completedOrdersCount < $coupon->required_completed_orders) {
                return 'Required completed orders not reached';
            }
        }

        if ($coupon->usage_limit !== null && $coupon->usages()->count() >= $coupon->usage_limit) {
            return 'Coupon usage limit reached';
        }

        if ($userId && $coupon->per_user_limit !== null) {
            $userUsageCount = $coupon->usages()->where('user_id', $userId)->count();

            if ($userUsageCount >= $coupon->per_user_limit) {
                return 'Per-user coupon limit reached';
            }
        }

        return null;
    }

    private function calculateDiscount(Coupon $coupon, float $amount): float
    {
        $discount = $coupon->discount_type === 'percent'
            ? ($amount * $coupon->discount_value) / 100
            : min($amount, $coupon->discount_value);

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
