<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends BaseAdminController
{
    public function index(Request $request): View
    {
        $filters = $request->only(['q', 'page']);

        return view('admin.carts.index', [
            'carts' => $this->apiService->get('admin/carts', array_filter($filters, fn ($value) => $value !== null && $value !== ''))['data'] ?? [],
            'filters' => $filters,
        ]);
    }

    public function show(int $cart): View
    {
        $response = $this->apiService->get("admin/carts/{$cart}");
        abort_unless($response['ok'], 404);

        return view('admin.carts.show', ['cart' => $response['data']]);
    }
}
