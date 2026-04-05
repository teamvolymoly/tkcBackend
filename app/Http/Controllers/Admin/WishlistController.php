<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WishlistController extends BaseAdminController
{
    public function index(Request $request): View
    {
        $filters = $request->only(['q', 'page']);

        return view('admin.wishlists.index', [
            'wishlists' => $this->apiService->get('admin/wishlists', array_filter($filters, fn ($value) => $value !== null && $value !== ''))['data'] ?? [],
            'filters' => $filters,
        ]);
    }

    public function destroy(int $wishlist): RedirectResponse
    {
        $response = $this->apiService->delete("admin/wishlists/{$wishlist}");

        if (! $response['ok']) {
            return back()->with('error', $response['message'] ?: 'Unable to remove wishlist item.');
        }

        return redirect()->route('admin.wishlists.index')->with('success', $response['message'] ?: 'Wishlist item removed successfully.');
    }
}
