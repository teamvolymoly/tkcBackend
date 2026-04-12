<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $items = Wishlist::with(['product.defaultVariant', 'product.variants'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json(['status' => true, 'data' => $items]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $wishlist = Wishlist::firstOrCreate([
            'user_id' => $request->user()->id,
            'product_id' => $request->product_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Wishlist updated',
            'data' => $wishlist->load(['product.defaultVariant', 'product.variants']),
        ], 201);
    }

    public function destroy(Request $request, $id)
    {
        $item = Wishlist::where('user_id', $request->user()->id)->where('id', $id)->firstOrFail();
        $item->delete();

        return response()->json(['status' => true, 'message' => 'Wishlist item removed']);
    }

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
