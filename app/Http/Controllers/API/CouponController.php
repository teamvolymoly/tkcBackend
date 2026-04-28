<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Services\CustomerCheckoutService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{
    public function __construct(private readonly CustomerCheckoutService $checkoutService)
    {
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
            'code' => 'required|string|max:255',
        ]);

        try {
            $summary = $this->checkoutService->applyCoupon($request->user(), $request->string('code')->value());
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return response()->json([
                'status' => false,
                'message' => data_get($exception->errors(), 'code.0') ?? 'Unable to apply coupon.',
                'errors' => $exception->errors(),
            ], 422);
        }

        return response()->json([
            'status' => true,
            'message' => 'Coupon applied successfully',
            'data' => $summary,
        ]);
    }

    public function remove(Request $request)
    {
        $summary = $this->checkoutService->removeCoupon($request->user());

        return response()->json([
            'status' => true,
            'message' => 'Coupon removed successfully',
            'data' => $summary,
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
}
