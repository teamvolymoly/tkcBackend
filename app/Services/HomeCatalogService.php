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
            return collect();
        }

        $products = Product::query()
            ->with([
                'defaultVariant' => fn ($variantQuery) => $variantQuery->where('status', true),
            ])
            ->withCount('reviews')
            ->where('status', true)
            ->whereIn('id', $soldProducts->keys())
            ->get();

        return $products
            ->sortByDesc(fn (Product $product) => (int) ($soldProducts[$product->id] ?? 0))
            ->take($limit)
            ->values()
            ->map(function (Product $product) {
                $defaultVariant = $product->defaultVariant;

                return [
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $defaultVariant?->price !== null ? (float) $defaultVariant->price : null,
                    'discount_price' => $defaultVariant?->compare_price !== null ? (float) $defaultVariant->compare_price : null,
                    'is_bestseller' => true,
                    'is_new' => $product->created_at?->gte(now()->subDays(30)) ?? false,
                    'review_count' => (int) $product->reviews_count,
                ];
            });
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
}
