<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CouponController extends BaseAdminController
{
    public function index(Request $request): View
    {
        $filters = $request->only(['q', 'page']);

        return view('admin.coupons.index', [
            'coupons' => $this->apiService->get('admin/coupons', array_filter($filters, fn ($value) => $value !== null && $value !== ''))['data'] ?? [],
            'filters' => $filters,
        ]);
    }

    public function create(): View
    {
        return view('admin.coupons.create', ['coupon' => null]);
    }

    public function show(int $coupon): View
    {
        $response = $this->apiService->get("coupons/{$coupon}");
        abort_unless($response['ok'], 404);

        return view('admin.coupons.show', ['coupon' => $response['data']]);
    }

    public function store(Request $request): RedirectResponse
    {
        $response = $this->apiService->post('coupons', $this->payload($request));

        if (! $response['ok']) {
            return $this->backWithApiError($response, 'Unable to create coupon.');
        }

        return redirect()->route('admin.coupons.index')->with('success', $response['message'] ?: 'Coupon created successfully.');
    }

    public function edit(int $coupon): View
    {
        $response = $this->apiService->get("coupons/{$coupon}");
        abort_unless($response['ok'], 404);

        return view('admin.coupons.edit', ['coupon' => $response['data']]);
    }

    public function update(Request $request, int $coupon): RedirectResponse
    {
        $response = $this->apiService->put("coupons/{$coupon}", $this->payload($request));

        if (! $response['ok']) {
            return $this->backWithApiError($response, 'Unable to update coupon.');
        }

        return redirect()->route('admin.coupons.index')->with('success', $response['message'] ?: 'Coupon updated successfully.');
    }

    public function destroy(int $coupon): RedirectResponse
    {
        $response = $this->apiService->delete("coupons/{$coupon}");

        if (! $response['ok']) {
            return back()->with('error', $response['message'] ?: 'Unable to delete coupon.');
        }

        return redirect()->route('admin.coupons.index')->with('success', $response['message'] ?: 'Coupon deleted successfully.');
    }

    private function payload(Request $request): array
    {
        $payload = $request->validate([
            'code' => ['required', 'string', 'max:255'],
            'discount_type' => ['required', 'in:fixed,percent'],
            'discount_value' => ['required', 'numeric', 'min:0'],
            'min_order_amount' => ['nullable', 'numeric', 'min:0'],
            'max_discount' => ['nullable', 'numeric', 'min:0'],
            'expiry_date' => ['nullable', 'date'],
            'usage_limit' => ['nullable', 'integer', 'min:1'],
            'per_user_limit' => ['nullable', 'integer', 'min:1'],
            'required_completed_orders' => ['nullable', 'integer', 'min:1'],
            'is_active' => ['nullable'],
        ]);

        $payload['is_active'] = $request->boolean('is_active');
        $payload['required_completed_orders'] = $payload['required_completed_orders'] ?? null;

        return $payload;
    }
}
