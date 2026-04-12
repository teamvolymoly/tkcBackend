<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ProductService
{
    public function __construct(private readonly HomeCatalogService $homeCatalogService)
    {
    }

    public function homeBestSellingProducts(int $limit = 8)
    {
        return $this->homeCatalogService->bestSellingProducts($limit);
    }

    public function paginatedCatalog(array $filters): LengthAwarePaginator
    {
        $query = Product::with([
            'category',
            'subcategory',
            'defaultVariant',
            'variants' => fn ($variantQuery) => $variantQuery->where('status', true)->orderByDesc('is_default')->orderBy('id'),
        ])->where('status', true);

        if (! empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (! empty($filters['q'])) {
            $term = $filters['q'];
            $query->where(function ($inner) use ($term) {
                $inner->where('name', 'like', "%{$term}%")
                    ->orWhere('tag_line_1', 'like', "%{$term}%")
                    ->orWhere('tag_line_2', 'like', "%{$term}%")
                    ->orWhere('description', 'like', "%{$term}%");
            });
        }

        if (array_key_exists('status', $filters) && $filters['status'] !== '') {
            $query->where('status', filter_var($filters['status'], FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE) ?? (bool) $filters['status']);
        }

        return $query->latest()->paginate(20)->withQueryString();
    }

    public function publicDetailBySlug(string $slug): array
    {
        $product = Product::with([
            'category',
            'subcategory',
            'reviews.user',
            'variants' => fn ($variantQuery) => $variantQuery->where('status', true)->orderByDesc('is_default')->orderBy('id'),
        ])->where('status', true)->where('slug', $slug)->firstOrFail();

        $activeVariants = $product->variants->values();
        $selectedVariant = $activeVariants->firstWhere('is_default', true) ?? $activeVariants->first();

        $discoverMore = Product::query()
            ->with(['category', 'subcategory', 'defaultVariant'])
            ->where('status', true)
            ->where('id', '!=', $product->id)
            ->latest()
            ->get()
            ->map(fn (Product $discoverProduct) => $this->transformDiscoverMoreProduct($discoverProduct))
            ->values()
            ->all();

        return [
            'id' => $product->id,
            'tag_line_1' => $product->tag_line_1,
            'name' => $product->name,
            'slug' => $product->slug,
            'tag_line_2' => $product->tag_line_2,
            'description' => $product->description,
            'category' => $product->category,
            'subcategory' => $product->subcategory,
            'breadcrumbs' => $this->buildBreadcrumbs($product),
            'gallery' => $product->gallery,
            'images' => $product->gallery,
            'ingredients' => $this->transformIngredients($product),
            'ingredients_list' => $this->transformIngredients($product),
            'faqs' => $this->transformFaqs($product),
            'variants' => $activeVariants->map(fn (ProductVariant $variant) => $this->transformVariant($variant))->all(),
            'default_variant_id' => $selectedVariant?->id,
            'default_variant' => $selectedVariant ? $this->transformVariant($selectedVariant) : null,
            'defaultVariant' => $selectedVariant ? $this->transformVariant($selectedVariant) : null,
            'selected_variant' => $selectedVariant ? $this->transformVariant($selectedVariant) : null,
            'price' => $selectedVariant?->price !== null ? (float) $selectedVariant->price : null,
            'discount_price' => $selectedVariant?->discount_price !== null ? (float) $selectedVariant->discount_price : null,
            'compare_price' => $selectedVariant?->discount_price !== null ? (float) $selectedVariant->discount_price : null,
            'currency' => 'INR',
            'brewing_rituals' => $this->transformBrewingRituals($selectedVariant, $product),
            'reviews' => [
                'average_rating' => round((float) $product->reviews->avg('rating'), 1),
                'count' => $product->reviews->count(),
                'items' => $product->reviews
                    ->sortByDesc('created_at')
                    ->values()
                    ->map(fn ($review) => [
                        'id' => $review->id,
                        'rating' => (int) $review->rating,
                        'review' => $review->review,
                        'created_at' => $review->created_at,
                        'user' => $review->user ? [
                            'id' => $review->user->id,
                            'name' => $review->user->name,
                            'email' => $review->user->email,
                        ] : null,
                    ])
                    ->all(),
            ],
            'discover_more' => $discoverMore,
            'discoverMore' => $discoverMore,
        ];
    }

    public function adminDetailById(int|string $id): Product
    {
        return Product::with([
            'category',
            'subcategory',
            'defaultVariant',
            'variants' => fn ($variantQuery) => $variantQuery->orderByDesc('is_default')->orderBy('id'),
        ])->findOrFail($id);
    }

    public function create(array $payload): Product
    {
        return DB::transaction(function () use ($payload) {
            $product = Product::create($this->buildProductPayload($payload));
            $this->syncVariants($product, $payload['variants'] ?? []);

            return $product->fresh(['category', 'subcategory', 'defaultVariant', 'variants']);
        });
    }

    public function update(Product $product, array $payload): Product
    {
        return DB::transaction(function () use ($product, $payload) {
            $product->update($this->buildProductPayload($payload, $product));

            if (array_key_exists('variants', $payload)) {
                $this->syncVariants($product, $payload['variants'] ?? [], true);
            }

            return $product->fresh(['category', 'subcategory', 'defaultVariant', 'variants']);
        });
    }

    public function delete(Product $product): void
    {
        $product->loadMissing('variants');
        $this->deleteProductMedia($product);
        $product->delete();
    }

    private function buildProductPayload(array $payload, ?Product $product = null): array
    {
        $data = [
            'category_id' => $payload['category_id'] ?? $product?->category_id,
            'subcategory_id' => $payload['subcategory_id'] ?? $product?->subcategory_id,
            'tag_line_1' => $payload['tag_line_1'] ?? $product?->tag_line_1,
            'name' => $payload['name'] ?? $product?->name,
            'tag_line_2' => $payload['tag_line_2'] ?? $product?->tag_line_2,
            'description' => $payload['description'] ?? $product?->description,
            'ingredients' => $this->prepareIngredients($payload['ingredients'] ?? ($product?->ingredients ?? []), $product),
            'faqs' => $payload['faqs'] ?? $product?->faqs ?? [],
            'status' => array_key_exists('status', $payload) ? (bool) $payload['status'] : ($product?->status ?? true),
        ];

        if ($product === null || (! empty($payload['name']) && $payload['name'] !== $product->name)) {
            $data['slug'] = $this->generateUniqueSlug($data['name'], $product?->id);
        }

        foreach (range(1, 5) as $index) {
            $column = 'image_'.$index;

            if (array_key_exists($column, $payload)) {
                $data[$column] = $this->storeOptionalFile($payload[$column], 'products/gallery', $product?->{$column});
            } elseif ($product !== null) {
                $data[$column] = $product->{$column};
            }
        }

        return $data;
    }

    private function syncVariants(Product $product, array $variants, bool $syncDeletes = false): void
    {
        $keptVariantIds = [];
        $defaultVariantId = null;

        foreach ($variants as $index => $variantData) {
            $payload = $this->buildVariantPayload($variantData);

            if (! empty($variantData['id'])) {
                $variant = $product->variants()->findOrFail($variantData['id']);

                if (ProductVariant::where('sku', $payload['sku'])->where('id', '!=', $variant->id)->exists()) {
                    throw ValidationException::withMessages([
                        'variants' => ["Variant SKU [{$payload['sku']}] is already in use."],
                    ]);
                }

                $variant->update($payload);
            } else {
                $variant = $product->variants()->create($payload);
            }

            $keptVariantIds[] = $variant->id;

            if (($variantData['is_default'] ?? false) || ($defaultVariantId === null && $index === 0)) {
                $defaultVariantId = $variant->id;
            }
        }

        if ($defaultVariantId !== null) {
            $product->variants()->update(['is_default' => false]);
            $product->variants()->whereKey($defaultVariantId)->update(['is_default' => true]);
        }

        if ($syncDeletes) {
            $deleteQuery = $product->variants();

            if ($keptVariantIds !== []) {
                $deleteQuery->whereNotIn('id', $keptVariantIds);
            }

            $deleteQuery->delete();
        }
    }

    private function buildVariantPayload(array $variantData): array
    {
        return [
            'name' => trim((string) ($variantData['name'] ?? '')) ?: 'Default Variant',
            'sku' => trim((string) ($variantData['sku'] ?? '')),
            'price' => $variantData['price'],
            'discount_price' => $variantData['discount_price'] ?? null,
            'weight' => $variantData['weight'] ?? null,
            'brewing_rituals' => $this->prepareBrewingRituals($variantData['brewing_rituals'] ?? []),
            'is_default' => false,
            'status' => (bool) ($variantData['status'] ?? true),
        ];
    }

    private function transformVariant(ProductVariant $variant): array
    {
        $price = $variant->price !== null ? (float) $variant->price : null;
        $discountPrice = $variant->discount_price !== null ? (float) $variant->discount_price : null;

        return [
            'id' => $variant->id,
            'name' => $variant->name,
            'variant_name' => $variant->name,
            'sku' => $variant->sku,
            'price' => $price,
            'formatted_price' => $price !== null ? number_format($price, 2, '.', '') : null,
            'discount_price' => $discountPrice,
            'compare_price' => $discountPrice,
            'formatted_discount_price' => $discountPrice !== null ? number_format($discountPrice, 2, '.', '') : null,
            'weight' => $variant->weight,
            'brewing_rituals' => $this->transformBrewingRituals($variant, $variant->product),
            'is_default' => (bool) $variant->is_default,
            'status' => (bool) $variant->status,
            'primary_image' => $variant->primary_image,
        ];
    }

    private function transformIngredients(Product $product): array
    {
        return collect($product->ingredients ?? [])
            ->filter(fn ($ingredient) => is_array($ingredient))
            ->values()
            ->map(fn (array $ingredient) => [
                'name' => $ingredient['name'] ?? null,
                'image' => $ingredient['image'] ?? null,
                'image_path' => $ingredient['image'] ?? null,
                'image_url' => $product->resolveMediaUrl($ingredient['image'] ?? null),
            ])
            ->all();
    }

    private function transformFaqs(Product $product): array
    {
        return collect($product->faqs ?? [])
            ->filter(fn ($faq) => is_array($faq))
            ->values()
            ->map(fn (array $faq) => [
                'question' => $faq['question'] ?? null,
                'answer' => $faq['answer'] ?? null,
            ])
            ->all();
    }

    private function transformBrewingRituals(?ProductVariant $variant, ?Product $product): array
    {
        if (! $variant) {
            return [];
        }

        return collect($variant->brewing_rituals ?? [])
            ->filter(fn ($ritual) => is_array($ritual))
            ->values()
            ->map(fn (array $ritual) => [
                'ritual' => $ritual['ritual'] ?? null,
                'text' => $ritual['ritual'] ?? null,
                'image' => $ritual['image'] ?? null,
                'image_path' => $ritual['image'] ?? null,
                'image_url' => $product?->resolveMediaUrl($ritual['image'] ?? null),
            ])
            ->all();
    }

    private function transformDiscoverMoreProduct(Product $product): array
    {
        $defaultVariant = $product->defaultVariant ?: $product->variants()->where('status', true)->orderByDesc('is_default')->first();

        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'tag_line_1' => $product->tag_line_1,
            'tag_line_2' => $product->tag_line_2,
            'category' => $product->category,
            'subcategory' => $product->subcategory,
            'default_variant' => $defaultVariant ? $this->transformVariant($defaultVariant) : null,
            'price' => $defaultVariant?->price !== null ? (float) $defaultVariant->price : null,
            'discount_price' => $defaultVariant?->discount_price !== null ? (float) $defaultVariant->discount_price : null,
            'compare_price' => $defaultVariant?->discount_price !== null ? (float) $defaultVariant->discount_price : null,
            'image_url' => collect($product->gallery)->first()['image_url'] ?? null,
        ];
    }

    private function buildBreadcrumbs(Product $product): array
    {
        return array_values(array_filter([
            ['label' => 'Home', 'value' => 'home'],
            $product->category ? ['label' => $product->category->name, 'value' => $product->category->slug] : null,
            ['label' => $product->name, 'value' => $product->slug],
        ]));
    }

    private function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        while (Product::where('slug', $slug)->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    private function storeOptionalFile(mixed $value, string $directory, ?string $currentPath = null): ?string
    {
        if (! $value instanceof UploadedFile) {
            return is_string($value) || $value === null ? $value : $currentPath;
        }

        if ($currentPath && ! preg_match('/^https?:\/\//i', $currentPath)) {
            Storage::disk('public')->delete($currentPath);
        }

        return $value->store($directory, 'public');
    }

    private function deleteProductMedia(Product $product): void
    {
        foreach (range(1, 5) as $index) {
            $path = $product->{'image_'.$index};

            if ($path && ! preg_match('/^https?:\/\//i', $path)) {
                Storage::disk('public')->delete($path);
            }
        }

        foreach ($product->ingredients ?? [] as $ingredient) {
            $path = $ingredient['image'] ?? null;

            if ($path && ! preg_match('/^https?:\/\//i', $path)) {
                Storage::disk('public')->delete($path);
            }
        }

        foreach ($product->variants as $variant) {
            foreach ($variant->brewing_rituals ?? [] as $ritual) {
                $path = $ritual['image'] ?? null;

                if ($path && ! preg_match('/^https?:\/\//i', $path)) {
                    Storage::disk('public')->delete($path);
                }
            }
        }
    }

    private function prepareIngredients(array $ingredients, ?Product $product = null): array
    {
        return collect($ingredients)
            ->filter(fn ($ingredient) => is_array($ingredient))
            ->values()
            ->map(function (array $ingredient, int $index) use ($product) {
                $currentPath = $product?->ingredients[$index]['image'] ?? null;

                return [
                    'name' => trim((string) ($ingredient['name'] ?? '')),
                    'image' => $this->storeOptionalFile($ingredient['image'] ?? null, 'products/ingredients', $currentPath),
                ];
            })
            ->filter(fn ($ingredient) => $ingredient['name'] !== '' || $ingredient['image'] !== null)
            ->values()
            ->all();
    }

    private function prepareBrewingRituals(array $rituals): array
    {
        return collect($rituals)
            ->filter(fn ($ritual) => is_array($ritual))
            ->values()
            ->map(fn (array $ritual) => [
                'ritual' => trim((string) ($ritual['ritual'] ?? '')),
                'image' => $this->storeOptionalFile($ritual['image'] ?? null, 'products/rituals'),
            ])
            ->filter(fn ($ritual) => $ritual['ritual'] !== '' || $ritual['image'] !== null)
            ->values()
            ->all();
    }
}
