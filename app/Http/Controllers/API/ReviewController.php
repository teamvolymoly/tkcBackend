<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Services\CustomerAccountService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ReviewController extends Controller
{
    public function __construct(
        private readonly CustomerAccountService $customerAccountService,
    ) {}

    public function eligible(Request $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Review eligible items fetched successfully',
            'data' => $this->customerAccountService->eligibleReviewItems($request->user()),
        ]);
    }

    public function orderEligibility(Request $request, string $orderId)
    {
        return response()->json([
            'status' => true,
            'message' => 'Order review eligibility fetched successfully',
            'data' => $this->customerAccountService->orderReviewEligibility($request->user(), $orderId),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_item_id' => ['required', 'integer'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'title' => ['nullable', 'string', 'max:255'],
            'comment' => ['nullable', 'string'],
        ]);

        try {
            $review = $this->customerAccountService->storeCustomerReview($request->user(), $validated);
        } catch (ValidationException $exception) {
            return response()->json([
                'status' => false,
                'message' => collect($exception->errors())->flatten()->first() ?: 'Unable to submit review.',
                'errors' => $exception->errors(),
            ], 422);
        }

        return response()->json([
            'status' => true,
            'message' => 'Review submitted successfully',
            'data' => [
                'review' => $review,
            ],
        ], 201);
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'title' => ['nullable', 'string', 'max:255'],
            'comment' => ['nullable', 'string'],
        ]);

        try {
            $review = $this->customerAccountService->updateCustomerReview($request->user(), $id, $validated);
        } catch (ValidationException $exception) {
            return response()->json([
                'status' => false,
                'message' => collect($exception->errors())->flatten()->first() ?: 'Unable to update review.',
                'errors' => $exception->errors(),
            ], 422);
        }

        return response()->json([
            'status' => true,
            'message' => 'Review updated successfully',
            'data' => [
                'review' => $review,
            ],
        ]);
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
