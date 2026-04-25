<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function adminIndex(Request $request)
    {
        $wishlists = Wishlist::with(['user', 'product.defaultVariant', 'product.variants'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = $request->q;
                $query->where(function ($inner) use ($term) {
                    $inner->whereHas('user', function ($userQuery) use ($term) {
                        $userQuery->where('name', 'like', '%'.$term.'%')
                            ->orWhere('email', 'like', '%'.$term.'%');
                    })->orWhereHas('product', function ($productQuery) use ($term) {
                        $productQuery->where('name', 'like', '%'.$term.'%');
                    });
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return response()->json(['status' => true, 'data' => $wishlists]);
    }

    public function adminDestroy($id)
    {
        $item = Wishlist::findOrFail($id);
        $item->delete();

        return response()->json(['status' => true, 'message' => 'Wishlist item removed successfully']);
    }
}
