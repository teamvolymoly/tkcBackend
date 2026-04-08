<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantImage;
use App\Services\HomeCatalogService;
use App\Support\ProductSchema;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
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
            'defaultVariant' => fn ($variantQuery) => $variantQuery->where('status', true)->with('primaryImage'),
            'variants' => fn ($variantQuery) => $variantQuery->where('status', true)->with(['inventory', 'images']),
        ])->where('status', true);

        if (! empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (! empty($filters['q'])) {
            $term = $filters['q'];
            $query->where(function ($inner) use ($term) {
                $inner->where('name', 'like', "%{$term}%")
                    ->orWhere('description', 'like', "%{$term}%")
                    ->orWhere('short_description', 'like', "%{$term}%");
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
            'defaultVariant' => fn ($variantQuery) => $variantQuery->where('status', true)->with('primaryImage'),
            'variants' => fn ($variantQuery) => $variantQuery->where('status', true)->with(['inventory', 'primaryImage', 'images']),
            'ingredientsList',
            'nutrition',
            'reviews.user',
        ])->where('status', true)->where('slug', $slug)->firstOrFail();

        $activeVariants = $product->variants
            ->where('status', true)
            ->values();

        $selectedVariant = $activeVariants->firstWhere('is_default', true)
            ?? $activeVariants->first();

        $discoverMore = Product::query()
            ->with([
                'category',
                'subcategory',
                'defaultVariant' => fn ($variantQuery) => $variantQuery->where('status', true)->with(['primaryImage', 'inventory', 'images']),
            ])
            ->where('status', true)
            ->where('id', '!=', $product->id)
            ->latest()
            ->get()
            ->map(fn (Product $discoverProduct) => $this->transformDiscoverMoreProduct($discoverProduct))
            ->values()
            ->all();

        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'short_description' => $product->short_description,
            'description' => $product->description,
            'allergic_information' => $product->allergic_information,
            'tea_type' => $product->tea_type,
            'disclaimer' => $product->disclaimer,
            'features' => $product->features ?? [],
            'category' => $product->category,
            'subcategory' => $product->subcategory,
            'breadcrumbs' => $this->buildBreadcrumbs($product),
            'gallery' => $this->buildGallery($selectedVariant, $activeVariants),
            'default_variant_id' => $selectedVariant?->id,
            'price' => $selectedVariant?->price !== null ? (float) $selectedVariant->price : null,
            'compare_price' => $selectedVariant?->compare_price !== null ? (float) $selectedVariant->compare_price : null,
            'currency' => 'INR',
            'variants' => $activeVariants->map(fn (ProductVariant $variant) => $this->transformVariant($variant))->values()->all(),
            'default_variant' => $selectedVariant ? $this->transformVariant($selectedVariant) : null,
            'defaultVariant' => $selectedVariant ? $this->transformVariant($selectedVariant) : null,
            'selected_variant' => $selectedVariant ? $this->transformVariant($selectedVariant) : null,
            'brewing_rituals' => $this->transformBrewingRituals($selectedVariant),
            'ingredients' => $product->ingredientsList
                ->sortBy('sort_order')
                ->values()
                ->map(fn ($ingredient) => [
                    'id' => $ingredient->id,
                    'name' => $ingredient->name,
                    'value' => $ingredient->value,
                    'image_path' => $ingredient->image_path,
                    'image_url' => $ingredient->image_url,
                    'sort_order' => $ingredient->sort_order,
                ])
                ->all(),
            'ingredients_text' => $product->ingredients,
            'ingredients_list' => $product->ingredientsList
                ->sortBy('sort_order')
                ->values()
                ->map(fn ($ingredient) => [
                    'id' => $ingredient->id,
                    'name' => $ingredient->name,
                    'value' => $ingredient->value,
                    'image_path' => $ingredient->image_path,
                    'image_url' => $ingredient->image_url,
                    'sort_order' => $ingredient->sort_order,
                ])
                ->all(),
            'nutrition' => $product->nutrition
                ->values()
                ->map(fn ($nutrition) => [
                    'id' => $nutrition->id,
                    'nutrient' => $nutrition->nutrient,
                    'value' => $nutrition->value,
                    'unit' => $nutrition->unit,
                ])
                ->all(),
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
            'defaultVariant.primaryImage',
            'variants.inventory',
            'variants.images',
            'ingredientsList',
            'nutrition',
        ])->findOrFail($id);
    }

    public function create(array $payload): Product
    {
        return DB::transaction(function () use ($payload) {
            $product = Product::create([
                'category_id' => $payload['category_id'] ?? null,
                'subcategory_id' => $payload['subcategory_id'] ?? null,
                'name' => $payload['name'],
                'slug' => $this->generateUniqueSlug($payload['name']),
                'short_description' => $payload['short_description'] ?? null,
                'allergic_information' => $payload['allergic_information'] ?? null,
                'tea_type' => $payload['tea_type'] ?? null,
                'disclaimer' => $payload['disclaimer'] ?? null,
                'description' => $payload['description'] ?? null,
                'ingredients' => $payload['ingredients'] ?? null,
                'features' => $payload['features'] ?? null,
                'status' => (bool) ($payload['status'] ?? true),
            ]);

            $this->syncVariants($product, $payload['variants'] ?? []);

            return $product->load(['category', 'subcategory', 'defaultVariant.primaryImage', 'variants.inventory', 'variants.images']);
        });
    }

    public function update(Product $product, array $payload): Product
    {
        return DB::transaction(function () use ($product, $payload) {
            $data = collect($payload)->only([
                'category_id',
                'subcategory_id',
                'name',
                'short_description',
                'allergic_information',
                'tea_type',
                'disclaimer',
                'description',
                'ingredients',
                'features',
                'status',
            ])->all();

            if (! empty($payload['name']) && $payload['name'] !== $product->name) {
                $data['slug'] = $this->generateUniqueSlug($payload['name'], $product->id);
            }

            $product->update($data);

            if (array_key_exists('variants', $payload)) {
                $this->syncVariants($product, $payload['variants'] ?? [], true);
            }

            return $product->fresh()->load(['category', 'subcategory', 'defaultVariant.primaryImage', 'variants.inventory', 'variants.images']);
        });
    }

    public function delete(Product $product): void
    {
        $product->delete();
    }

    private function syncVariants(Product $product, array $variants, bool $syncDeletes = false): void
    {
        $keptVariantIds = [];
        $defaultVariantId = null;

        foreach ($variants as $index => $variantData) {
            $payload = $this->buildVariantPayload($variantData);

            if (! empty($variantData['id'])) {
                $variant = $product->variants()->findOrFail($variantData['id']);

                if (
                    ProductVariant::where('sku', $payload['sku'])
                        ->where('id', '!=', $variant->id)
                        ->exists()
                ) {
                    throw ValidationException::withMessages([
                        'variants' => ["Variant SKU [{$payload['sku']}] is already in use."],
                    ]);
                }

                $variant->update($payload);
            } else {
                $variant = $product->variants()->create($payload);
            }

            $this->syncVariantImages($variant, $variantData['images'] ?? []);

            $currentInventory = $variant->inventory()->first();
            $variant->inventory()->updateOrCreate(
                ['variant_id' => $variant->id],
                [
                    'stock' => $payload['stock'],
                    'reserved_stock' => $currentInventory?->reserved_stock ?? 0,
                    'warehouse' => $currentInventory?->warehouse ?? 'default',
                ]
            );

            $keptVariantIds[] = $variant->id;

            if (($variantData['is_default'] ?? false) || ($defaultVariantId === null && $index === 0)) {
                $defaultVariantId = $variant->id;
            }
        }

        if ($defaultVariantId !== null && ProductSchema::hasColumn('product_variants', 'is_default')) {
            $product->variants()->update(['is_default' => false]);
            $product->variants()->whereKey($defaultVariantId)->update(['is_default' => true]);
        }

        if ($syncDeletes) {
            $deleteQuery = $product->variants();

            if (! empty($keptVariantIds)) {
                $deleteQuery->whereNotIn('id', $keptVariantIds);
            }

            $deleteQuery->get()->each(function (ProductVariant $variant) {
                $variant->inventory()?->delete();
                $variant->delete();
            });
        }
    }

    private function syncVariantImages(ProductVariant $variant, array $images): void
    {
        if ($images === []) {
            $this->ensurePrimaryVariantImage($variant);

            return;
        }

        $primaryImageId = null;
        $nextSortOrder = (int) ($variant->images()->max('sort_order') ?? -1) + 1;

        foreach ($images as $index => $imageData) {
            $uploadedFile = $imageData['file'] ?? null;
            $imageId = $imageData['id'] ?? null;

            if (! $uploadedFile instanceof UploadedFile && ! $imageId) {
                continue;
            }

            $image = $imageId
                ? $variant->images()->findOrFail($imageId)
                : new ProductVariantImage(['variant_id' => $variant->id]);

            if ($uploadedFile instanceof UploadedFile) {
                if ($image->exists && $image->image_path) {
                    Storage::disk('public')->delete($image->image_path);
                }

                $image->image_path = $uploadedFile->store('products/variants', 'public');
            }

            if (! $image->image_path) {
                continue;
            }

            $image->sort_order = isset($imageData['sort_order'])
                ? (int) $imageData['sort_order']
                : $nextSortOrder + $index;
            $image->is_primary = false;
            $image->save();

            if (($imageData['is_primary'] ?? false) && $primaryImageId === null) {
                $primaryImageId = $image->id;
            }
        }

        if ($primaryImageId !== null) {
            $variant->images()->update(['is_primary' => false]);
            $variant->images()->whereKey($primaryImageId)->update(['is_primary' => true]);
        } else {
            $this->ensurePrimaryVariantImage($variant);
        }
    }

    private function ensurePrimaryVariantImage(ProductVariant $variant): void
    {
        if (! $variant->images()->exists()) {
            return;
        }

        if ($variant->images()->where('is_primary', true)->exists()) {
            return;
        }

        $primary = $variant->images()->orderBy('sort_order')->orderBy('id')->first();

        if ($primary) {
            $variant->images()->whereKey($primary->id)->update(['is_primary' => true]);
        }
    }

    private function buildVariantPayload(array $variantData): array
    {
        $size = trim((string) ($variantData['size'] ?? ''));
        $color = trim((string) ($variantData['color'] ?? ''));
        $variantName = trim((string) ($variantData['variant_name'] ?? ''));

        if ($variantName === '') {
            $variantName = collect([$size, $color])->filter()->implode(' / ');
        }

        $payload = [
            'variant_name' => $variantName !== '' ? $variantName : 'Default Variant',
            'size' => $size !== '' ? $size : null,
            'color' => $color !== '' ? $color : null,
            'sku' => $variantData['sku'],
            'price' => $variantData['price'],
            'stock' => (int) ($variantData['stock'] ?? 0),
            'weight' => $variantData['weight'] ?? null,
            'dimensions' => $variantData['dimensions'] ?? null,
            'net_weight' => $variantData['net_weight'] ?? null,
            'tags' => $variantData['tags'] ?? null,
            'brewing_rituals' => $variantData['brewing_rituals'] ?? null,
            'status' => (bool) ($variantData['status'] ?? true),
        ];

        if (ProductSchema::hasColumn('product_variants', 'compare_price')) {
            $payload['compare_price'] = $variantData['compare_price'] ?? null;
        }

        if (ProductSchema::hasColumn('product_variants', 'is_default')) {
            $payload['is_default'] = false;
        }

        return $payload;
    }

    private function buildBreadcrumbs(Product $product): array
    {
        return array_values(array_filter([
            ['label' => 'Home', 'value' => 'home'],
            $product->category ? ['label' => $product->category->name, 'value' => $product->category->slug] : null,
            ['label' => $product->name, 'value' => $product->slug],
        ]));
    }

    private function buildGallery(?ProductVariant $selectedVariant, Collection $variants): array
    {
        $images = collect();

        if ($selectedVariant) {
            $images = $images->merge($selectedVariant->images);
        }

        $images = $images->merge($variants->flatMap(fn (ProductVariant $variant) => $variant->images));

        return $images
            ->unique(fn ($image) => $image->id ?: $image->image_url)
            ->values()
            ->map(fn ($image) => [
                'id' => $image->id,
                'image_path' => $image->image_path,
                'image_url' => $image->image_url,
                'is_primary' => (bool) $image->is_primary,
                'sort_order' => $image->sort_order,
            ])
            ->all();
    }

    private function transformVariant(ProductVariant $variant): array
    {
        $price = $variant->price !== null ? (float) $variant->price : null;

        return [
            'id' => $variant->id,
            'variant_name' => $variant->variant_name,
            'size' => $variant->size,
            'color' => $variant->color,
            'sku' => $variant->sku,
            'price' => $price,
            'formatted_price' => $price !== null ? number_format($price, 2, '.', '') : null,
            'compare_price' => $variant->compare_price !== null ? (float) $variant->compare_price : null,
            'formatted_compare_price' => $variant->compare_price !== null ? number_format((float) $variant->compare_price, 2, '.', '') : null,
            'stock' => (int) ($variant->inventory?->stock ?? $variant->stock ?? 0),
            'weight' => $variant->weight,
            'dimensions' => $variant->dimensions,
            'net_weight' => $variant->net_weight,
            'tags' => $variant->tags ?? [],
            'brewing_rituals' => $variant->brewing_rituals ?? [],
            'is_default' => (bool) $variant->is_default,
            'status' => (bool) $variant->status,
            'primary_image' => $variant->primaryImage ? [
                'id' => $variant->primaryImage->id,
                'image_url' => $variant->primaryImage->image_url,
                'image_path' => $variant->primaryImage->image_path,
            ] : null,
            'images' => $variant->images->map(fn ($image) => [
                'id' => $image->id,
                'image_url' => $image->image_url,
                'image_path' => $image->image_path,
                'is_primary' => (bool) $image->is_primary,
                'sort_order' => $image->sort_order,
            ])->values()->all(),
        ];
    }

    private function transformBrewingRituals(?ProductVariant $selectedVariant): array
    {
        if (! $selectedVariant) {
            return [];
        }

        return collect($selectedVariant->brewing_rituals ?? [])
            ->filter(fn ($ritual) => is_array($ritual))
            ->values()
            ->map(fn (array $ritual) => [
                'group' => $ritual['group'] ?? null,
                'title' => $ritual['title'] ?? null,
                'icon' => $ritual['icon'] ?? null,
                'text' => $ritual['text'] ?? null,
                'value' => $ritual['value'] ?? null,
            ])
            ->all();
    }

    private function transformDiscoverMoreProduct(Product $product): array
    {
        $defaultVariant = $product->defaultVariant;
        $price = $defaultVariant?->price !== null ? (float) $defaultVariant->price : null;

        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'short_description' => $product->short_description,
            'category' => $product->category,
            'subcategory' => $product->subcategory,
            'default_variant' => $defaultVariant ? $this->transformVariant($defaultVariant) : null,
            'price' => $price,
            'compare_price' => $defaultVariant?->compare_price !== null ? (float) $defaultVariant->compare_price : null,
            'image_url' => $defaultVariant?->primaryImage?->image_url,
        ];
    }

    private function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        while (
            Product::where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}




