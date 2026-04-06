<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantImage;
use App\Services\HomeCatalogService;
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

    public function publicDetailBySlug(string $slug): Product
    {
        return Product::with([
            'category',
            'subcategory',
            'defaultVariant' => fn ($variantQuery) => $variantQuery->where('status', true)->with('primaryImage'),
            'variants' => fn ($variantQuery) => $variantQuery->where('status', true)->with(['inventory', 'images']),
            'ingredientsList',
            'nutrition',
            'reviews.user',
        ])->where('status', true)->where('slug', $slug)->firstOrFail();
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

        if ($defaultVariantId !== null) {
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

        return [
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
            'is_default' => false,
            'status' => (bool) ($variantData['status'] ?? true),
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



