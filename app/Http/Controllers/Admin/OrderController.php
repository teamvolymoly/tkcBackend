<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends BaseAdminController
{
    public function index(Request $request): View
    {
        $filters = $request->only(['q', 'status', 'page']);

        return view('admin.orders.index', [
            'orders' => $this->apiService->get('admin/orders', array_filter($filters, fn ($value) => $value !== null && $value !== ''))['data'] ?? [],
            'filters' => $filters,
        ]);
    }

    public function show(int $order): View
    {
        $response = $this->apiService->get("admin/orders/{$order}");
        abort_unless($response['ok'], 404);

        return view('admin.orders.show', [
            'order' => $response['data'],
        ]);
    }

    public function updateStatus(Request $request, int $order): RedirectResponse
    {
        $response = $this->apiService->put("admin/orders/{$order}/status", $request->validate([
            'status' => ['required', 'string'],
        ]));

        if (! $response['ok']) {
            return $this->backWithApiError($response, 'Unable to update order status.');
        }

        return redirect()->route('admin.orders.show', $order)->with('success', $response['message'] ?: 'Order status updated successfully.');
    }

    public function bulkUpdateStatus(Request $request): RedirectResponse
    {
        $payload = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer'],
            'status' => ['required', 'string'],
        ]);

        $failures = collect($payload['ids'])->map(function ($id) use ($payload) {
            $response = $this->apiService->put("admin/orders/{$id}/status", ['status' => $payload['status']]);

            return $response['ok'] ? null : ($response['message'] ?: "Order {$id} failed");
        })->filter()->values();

        if ($failures->isNotEmpty()) {
            return back()->with('error', 'Some orders could not be updated: '.$failures->implode(', '));
        }

        return redirect()->route('admin.orders.index')->with('success', 'Selected orders updated successfully.');
    }
}
