<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $review = Review::updateOrCreate(
            ['product_id' => $request->product_id, 'user_id' => $request->user()->id],
            ['rating' => $request->rating, 'review' => $request->review]
        );

        return response()->json(['status' => true, 'message' => 'Review saved', 'data' => $review], 201);
    }

    public function productReviews($id)
    {
        $reviews = Review::with('user:id,name')
            ->where('product_id', $id)
            ->latest()
            ->get();

        return response()->json(['status' => true, 'data' => $reviews]);
    }

    public function destroy(Request $request, $id)
    {
        $review = Review::where('user_id', $request->user()->id)->findOrFail($id);
        $review->delete();

        return response()->json(['status' => true, 'message' => 'Review deleted']);
    }

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
        $review = Review::with(['user', 'product.defaultVariant.primaryImage', 'product.variants.images'])->findOrFail($id);

        return response()->json(['status' => true, 'data' => $review]);
    }

    public function adminDestroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return response()->json(['status' => true, 'message' => 'Review deleted successfully']);
    }
}
