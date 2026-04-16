<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:1',
            'limit' => 'nullable|integer|min:1|max:20',
        ]);

        $limit = (int) $request->integer('limit', 5);

        $results = Product::with('variants')
            ->where('status', true)
            ->where(function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->q.'%')
                    ->orWhere('tag_line_1', 'like', '%'.$request->q.'%')
                    ->orWhere('tag_line_2', 'like', '%'.$request->q.'%')
                    ->orWhere('description', 'like', '%'.$request->q.'%');
            })
            ->latest()
            ->limit($limit)
            ->get()
            ->map(function (Product $product) {
                $variant = $product->variants->sortByDesc('is_default')->first();
                $image = $variant?->primary_image['image_url'] ?? $product->resolveMediaUrl($product->image_1);

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'image' => $image,
                    'price' => (float) ($variant?->discount_price && $variant->discount_price > 0
                        ? $variant->discount_price
                        : $variant?->price),
                ];
            })
            ->values();

        return response()->json(['status' => true, 'data' => $results]);
    }
}
