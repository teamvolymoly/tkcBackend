<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends BaseAdminController
{
    public function index(Request $request): View
    {
        $filters = $request->only(['q', 'status', 'payment_method', 'page']);

        return view('admin.payments.index', [
            'payments' => $this->apiService->get('admin/payments', array_filter($filters, fn ($value) => $value !== null && $value !== ''))['data'] ?? [],
            'filters' => $filters,
        ]);
    }

    public function show(int $payment): View
    {
        $response = $this->apiService->get("admin/payments/{$payment}");
        abort_unless($response['ok'], 404);

        return view('admin.payments.show', ['payment' => $response['data']]);
    }

    public function update(Request $request, int $payment): RedirectResponse
    {
        $response = $this->apiService->put("admin/payments/{$payment}", $request->validate([
            'payment_method' => ['required', 'string', 'max:100'],
            'transaction_id' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:initiated,success,failed,refunded'],
        ]));

        if (! $response['ok']) {
            return $this->backWithApiError($response, 'Unable to update payment.');
        }

        return redirect()->route('admin.payments.show', $payment)->with('success', $response['message'] ?: 'Payment updated successfully.');
    }
}
