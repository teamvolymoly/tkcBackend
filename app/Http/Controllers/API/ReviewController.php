<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function adminIndex(Request $request)
    {
        $reviews = Review::with(['user:id,name,email', 'product:id,name,slug'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = $request->q;
                $query->where(function ($inner) use ($term) {
                    $inner->where('review', 'like', '%'.$term.'%')
                        ->orWhereHas('product', fn ($productQuery) => $productQuery->where('name', 'like', '%'.$term.'%'))
                        ->orWhereHas('user', fn ($userQuery) => $userQuery->where('name', 'like', '%'.$term.'%')->orWhere('email', 'like', '%'.$term.'%'));
                });
            })
            ->when($request->filled('rating'), fn ($query) => $query->where('rating', $request->integer('rating')))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return response()->json(['status' => true, 'data' => $reviews]);
    }

    public function adminShow($id)
    {
        $review = Review::with(['user', 'product.defaultVariant', 'product.variants'])->findOrFail($id);

        return response()->json(['status' => true, 'data' => $review]);
    }

    public function adminDestroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return response()->json(['status' => true, 'message' => 'Review deleted successfully']);
    }
}
