<?php

namespace App\Services;

use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Collection;

class HomeCatalogService
{
    public function bestSellingProducts(int $limit = 8): Collection
    {
        $soldProducts = OrderItem::query()
            ->selectRaw('product_id, SUM(quantity) as total_sold')
            ->whereNotNull('product_id')
            ->whereHas('order', fn ($query) => $query->whereIn('status', ['delivered', 'completed']))
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->limit($limit)
            ->pluck('total_sold', 'product_id');

        if ($soldProducts->isEmpty()) {
            return Product::query()
                ->with([
                    'defaultVariant' => fn ($variantQuery) => $variantQuery->where('status', true),
                ])
                ->withCount('reviews')
                ->withAvg('reviews', 'rating')
                ->where('status', true)
                ->inRandomOrder()
                ->limit($limit)
                ->get()
                ->map(fn (Product $product) => $this->transformBestSellingProduct($product, false));
        }

        $products = Product::query()
            ->with([
                'defaultVariant' => fn ($variantQuery) => $variantQuery->where('status', true),
            ])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->where('status', true)
            ->whereIn('id', $soldProducts->keys())
            ->get();

        return $products
            ->sortByDesc(fn (Product $product) => (int) ($soldProducts[$product->id] ?? 0))
            ->take($limit)
            ->values()
            ->map(fn (Product $product) => $this->transformBestSellingProduct($product, true));
    }

    public function popularCategories(int $limit = 6): Collection
    {
        $soldCategories = OrderItem::query()
            ->selectRaw('products.category_id as category_id, SUM(order_items.quantity) as total_sold')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->whereNotNull('products.category_id')
            ->where('products.status', true)
            ->whereIn('orders.status', ['delivered', 'completed'])
            ->groupBy('products.category_id')
            ->orderByDesc('total_sold')
            ->limit($limit)
            ->pluck('total_sold', 'category_id');

        if ($soldCategories->isEmpty()) {
            return collect();
        }

        $categories = Category::query()
            ->whereNull('parent_id')
            ->where('status', true)
            ->whereIn('id', $soldCategories->keys())
            ->get();

        return $categories
            ->sortByDesc(fn (Category $category) => (int) ($soldCategories[$category->id] ?? 0))
            ->take($limit)
            ->values()
            ->map(function (Category $category) use ($soldCategories) {
                return [
                    'id' => $category->id,
                    'slug' => $category->slug,
                    'img' => $category->image_url,
                    'name' => $category->name,
                    'description' => $category->description,
                    'sold_quantity' => (int) ($soldCategories[$category->id] ?? 0),
                ];
            });
    }

    private function transformBestSellingProduct(Product $product, bool $isBestseller): array
    {
        $defaultVariant = $product->defaultVariant;
        $price = $defaultVariant?->price !== null ? (float) $defaultVariant->price : null;
        $discountPrice = $defaultVariant?->discount_price !== null ? (float) $defaultVariant->discount_price : null;
        $gallery = collect($product->gallery)->values();
        $isNew = $product->created_at?->gte(now()->subDays(30)) ?? false;

        return [
            'id' => $product->id,
            'img1' => $gallery->get(0)['image_url'] ?? null,
            'img2' => $gallery->get(1)['image_url'] ?? null,
            'avg_rating' => round((float) ($product->reviews_avg_rating ?? 0), 1),
            'product_name' => $product->name,
            'name' => $product->name,
            'price' => $price,
            'discount_price' => $discountPrice,
            'tag' => $this->buildBestSellingTags($product, $defaultVariant?->name, $price, $discountPrice, $isBestseller, $isNew),
            'slug' => $product->slug,
            'is_bestseller' => $isBestseller,
            'is_new' => $isNew,
        ];
    }

    private function buildBestSellingTags(Product $product, ?string $variantName, ?float $price, ?float $discountPrice, bool $isBestseller, bool $isNew): array
    {
        $tags = [];

        if ($price !== null && $discountPrice !== null && $discountPrice < $price && $price > 0) {
            $discountPercent = (int) round((($price - $discountPrice) / $price) * 100);

            if ($discountPercent > 0) {
                $tags[] = "{$discountPercent}% off";
            }
        }

        if ($isBestseller) {
            $tags[] = 'bestseller';
        }

        if ($isNew) {
            $tags[] = 'new';
        }

        $samplerText = strtolower(trim(($product->name ?? '').' '.($variantName ?? '')));

        if (str_contains($samplerText, 'sampler')) {
            $tags[] = 'sampler';
        }

        return array_values(array_unique($tags));
    }
}
