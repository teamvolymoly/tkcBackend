<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventoryController extends BaseAdminController
{
    public function index(Request $request): View
    {
        $filters = $request->only(['page']);

        return view('admin.inventory.index', [
            'inventory' => $this->apiService->get('inventory', array_filter($filters, fn ($value) => $value !== null && $value !== ''))['data'] ?? [],
        ]);
    }

    public function update(Request $request, int $variant): RedirectResponse
    {
        $payload = $request->validate([
            'stock' => ['required', 'integer', 'min:0'],
            'reserved_stock' => ['required', 'integer', 'min:0'],
            'warehouse' => ['nullable', 'string', 'max:255'],
        ]);

        $response = $this->apiService->put("inventory/{$variant}", $payload);

        if (! $response['ok']) {
            return $this->backWithApiError($response, 'Unable to update inventory.');
        }

        return back()->with('success', $response['message'] ?: 'Inventory updated successfully.');
    }
}
