<?php

namespace App\Services;

use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
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

    public function catalog(array $filters): array
    {
        $page = max(1, (int) ($filters['page'] ?? 1));
        $limit = min(48, max(1, (int) ($filters['limit'] ?? 12)));
        $includes = $this->parseIncludes($filters['include'] ?? null);
        $query = $this->catalogQuery($filters, $includes);
        $paginator = $query->paginate($limit, ['products.*'], 'page', $page)->withQueryString();

        return [
            'items' => $paginator->getCollection()
                ->map(fn (Product $product) => $this->transformCatalogProduct($product, $includes))
                ->all(),
            'pagination' => [
                'page' => $paginator->currentPage(),
                'limit' => $paginator->perPage(),
                'total_items' => $paginator->total(),
                'total_pages' => $paginator->lastPage(),
            ],
        ];
    }

    public function searchProducts(array $filters): array
    {
        $page = max(1, (int) ($filters['page'] ?? 1));
        $limit = min(20, max(1, (int) ($filters['limit'] ?? 10)));
        $search = trim((string) ($filters['q'] ?? ''));

        if ($search === '') {
            return [
                'items' => [],
                'pagination' => [
                    'page' => $page,
                    'limit' => $limit,
                    'total_items' => 0,
                    'total_pages' => 0,
                ],
            ];
        }

        $paginator = Product::query()
            ->with([
                'variants' => fn ($variantQuery) => $variantQuery
                    ->where('status', true)
                    ->orderByDesc('is_default')
                    ->orderBy('id'),
            ])
            ->where('status', true)
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('tag_line_1', 'like', "%{$search}%")
                    ->orWhere('tag_line_2', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate($limit, ['*'], 'page', $page);

        return [
            'items' => $paginator->getCollection()
                ->map(fn (Product $product) => $this->transformSearchProduct($product))
                ->all(),
            'pagination' => [
                'page' => $paginator->currentPage(),
                'limit' => $paginator->perPage(),
                'total_items' => $paginator->total(),
                'total_pages' => $paginator->lastPage(),
            ],
        ];
    }

    public function catalogFilters(): array
    {
        return Cache::remember('api.products.filters.v1', now()->addHours(12), function () {
            $categories = Category::query()
                ->whereNull('parent_id')
                ->where('status', true)
                ->orderBy('name')
                ->get(['id', 'name', 'slug'])
                ->map(fn (Category $category) => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                ])
                ->values()
                ->all();

            $subcategories = Category::query()
                ->whereNotNull('parent_id')
                ->where('status', true)
                ->orderBy('name')
                ->get(['id', 'parent_id', 'name', 'slug'])
                ->map(fn (Category $category) => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'category_id' => $category->parent_id,
                ])
                ->values()
                ->all();

            $priceStats = ProductVariant::query()
                ->join('products', 'products.id', '=', 'product_variants.product_id')
                ->where('products.status', true)
                ->where('product_variants.status', true)
                ->selectRaw('MIN(CASE WHEN discount_price IS NOT NULL AND discount_price > 0 AND discount_price < price THEN discount_price ELSE price END) as min_price')
                ->selectRaw('MAX(CASE WHEN discount_price IS NOT NULL AND discount_price > 0 AND discount_price < price THEN discount_price ELSE price END) as max_price')
                ->first();

            $discountTags = ProductVariant::query()
                ->join('products', 'products.id', '=', 'product_variants.product_id')
                ->where('products.status', true)
                ->where('product_variants.status', true)
                ->whereNotNull('product_variants.discount_price')
                ->whereColumn('product_variants.discount_price', '<', 'product_variants.price')
                ->selectRaw('ROUND(((product_variants.price - product_variants.discount_price) / product_variants.price) * 100) as discount_percent')
                ->pluck('discount_percent')
                ->filter(fn ($value) => $value !== null && (int) $value > 0)
                ->map(fn ($value) => (int) $value.'% OFF')
                ->unique()
                ->sort()
                ->values()
                ->all();

            $caffeine = Product::query()
                ->where('status', true)
                ->whereNotNull('caffeine')
                ->pluck('caffeine')
                ->map(fn ($value) => trim((string) $value))
                ->filter()
                ->unique()
                ->values()
                ->all();

            $collections = Product::query()
                ->where('status', true)
                ->whereNotNull('collection')
                ->pluck('collection')
                ->flatMap(fn ($value) => $this->splitCollectionValues($value))
                ->unique()
                ->values()
                ->all();

            $tags = collect(['Bestseller', 'New'])
                ->merge($discountTags)
                ->unique()
                ->values()
                ->all();

            return [
                'categories' => $categories,
                'subcategories' => $subcategories,
                'price_range' => [
                    'min' => isset($priceStats?->min_price) ? (float) $priceStats->min_price : 0.0,
                    'max' => isset($priceStats?->max_price) ? (float) $priceStats->max_price : 0.0,
                ],
                'rating_options' => [5, 4, 3],
                'tags' => $tags,
                'caffeine' => $caffeine,
                'collections' => $collections,
            ];
        });
    }

    public function publicDetailBySlug(string $slug): array
    {
        $product = Product::with([
            'category',
            'subcategory',
            'reviews' => fn ($reviewQuery) => $reviewQuery->where('status', 'approved')->with('user'),
            'variants' => fn ($variantQuery) => $variantQuery->where('status', true)->orderByDesc('is_default')->orderBy('id'),
        ])->where('status', true)->where('slug', $slug)->firstOrFail();

        return $this->transformPublicProduct($product);
    }

    private function catalogQuery(array $filters, array $includes): Builder
    {
        $salesSubQuery = OrderItem::query()
            ->selectRaw('product_id, SUM(quantity) as total_sold')
            ->whereNotNull('product_id')
            ->whereHas('order', fn ($query) => $query->whereIn('status', ['delivered', 'completed']))
            ->groupBy('product_id');

        $displayPriceSubQuery = ProductVariant::query()
            ->selectRaw('CASE WHEN discount_price IS NOT NULL AND discount_price > 0 AND discount_price < price THEN discount_price ELSE price END')
            ->whereColumn('product_id', 'products.id')
            ->where('status', true)
            ->orderByDesc('is_default')
            ->orderBy('id')
            ->limit(1);

        $comparePriceSubQuery = ProductVariant::query()
            ->select('price')
            ->whereColumn('product_id', 'products.id')
            ->where('status', true)
            ->orderByDesc('is_default')
            ->orderBy('id')
            ->limit(1);

        $isAdminRequest = request()->user()?->hasRole('admin') ?? false;

        $query = Product::query()
            ->select('products.*')
            ->leftJoinSub($salesSubQuery, 'sales_stats', fn ($join) => $join->on('sales_stats.product_id', '=', 'products.id'))
            ->selectRaw('COALESCE(sales_stats.total_sold, 0) as total_sold')
            ->selectSub($displayPriceSubQuery, 'display_price')
            ->selectSub($comparePriceSubQuery, 'compare_price')
            ->withAvg(['reviews as average_rating' => fn ($reviewQuery) => $reviewQuery->where('status', 'approved')], 'rating')
            ->withCount([
                'reviews as rating_count' => fn ($reviewQuery) => $reviewQuery->where('status', 'approved'),
                'variants as active_variants_count' => fn ($variantQuery) => $variantQuery->where('status', true),
            ]);

        if ($isAdminRequest) {
            if (array_key_exists('status', $filters) && $filters['status'] !== '') {
                $query->where('products.status', filter_var($filters['status'], FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE) ?? (bool) $filters['status']);
            }
        } else {
            $query->where('products.status', true);
        }

        $relations = [];

        if (in_array('category', $includes, true)) {
            $relations[] = 'category';
        }

        if (in_array('subcategory', $includes, true)) {
            $relations[] = 'subcategory';
        }

        if (in_array('variants', $includes, true)) {
            $relations['variants'] = fn ($variantQuery) => $variantQuery
                ->where('status', true)
                ->orderByDesc('is_default')
                ->orderBy('id');
        }

        if ($relations !== []) {
            $query->with($relations);
        }

        $categoryId = $this->resolveCategoryIdentifier($filters['category'] ?? $filters['category_id'] ?? null, false);
        if (($filters['category'] ?? $filters['category_id'] ?? null) !== null) {
            $categoryId ? $query->where('products.category_id', $categoryId) : $query->whereRaw('1 = 0');
        }

        $subcategoryId = $this->resolveCategoryIdentifier($filters['subcategory'] ?? $filters['subcategory_id'] ?? null, true);
        if (($filters['subcategory'] ?? $filters['subcategory_id'] ?? null) !== null) {
            $subcategoryId ? $query->where('products.subcategory_id', $subcategoryId) : $query->whereRaw('1 = 0');
        }

        $search = trim((string) ($filters['search'] ?? $filters['q'] ?? ''));
        if ($search !== '') {
            $query->where(function ($inner) use ($search) {
                $inner->where('products.name', 'like', "%{$search}%")
                    ->orWhere('products.tag_line_1', 'like', "%{$search}%")
                    ->orWhere('products.tag_line_2', 'like', "%{$search}%")
                    ->orWhere('products.description', 'like', "%{$search}%");
            });
        }

        if (($filters['caffeine'] ?? null) !== null && $filters['caffeine'] !== '') {
            $query->where('products.caffeine', trim((string) $filters['caffeine']));
        }

        if (($filters['collection'] ?? null) !== null && $filters['collection'] !== '') {
            $query->whereRaw('FIND_IN_SET(?, REPLACE(products.collection, ", ", ",")) > 0', [trim((string) $filters['collection'])]);
        }

        if (($filters['price_min'] ?? null) !== null && $filters['price_min'] !== '') {
            $priceMin = (float) $filters['price_min'];
            $query->whereHas('variants', function ($variantQuery) use ($priceMin) {
                $variantQuery->where('status', true)
                    ->whereRaw('CASE WHEN discount_price IS NOT NULL AND discount_price > 0 AND discount_price < price THEN discount_price ELSE price END >= ?', [$priceMin]);
            });
        }

        if (($filters['price_max'] ?? null) !== null && $filters['price_max'] !== '') {
            $priceMax = (float) $filters['price_max'];
            $query->whereHas('variants', function ($variantQuery) use ($priceMax) {
                $variantQuery->where('status', true)
                    ->whereRaw('CASE WHEN discount_price IS NOT NULL AND discount_price > 0 AND discount_price < price THEN discount_price ELSE price END <= ?', [$priceMax]);
            });
        }

        if (($filters['rating_min'] ?? null) !== null && $filters['rating_min'] !== '') {
            $query->having('average_rating', '>=', (float) $filters['rating_min']);
        }

        if (array_key_exists('in_stock', $filters) && $filters['in_stock'] !== '') {
            $inStock = filter_var($filters['in_stock'], FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE);
            if ($inStock !== null) {
                $inStock
                    ? $query->whereHas('variants', fn ($variantQuery) => $variantQuery->where('status', true))
                    : $query->whereDoesntHave('variants', fn ($variantQuery) => $variantQuery->where('status', true));
            }
        }

        if (($filters['tag'] ?? null) !== null && $filters['tag'] !== '') {
            $this->applyTagFilter($query, (string) $filters['tag']);
        }

        $this->applyCatalogSorting($query, (string) ($filters['sort'] ?? 'relevance'), $search);

        return $query;
    }

    private function transformCatalogProduct(Product $product, array $includes): array
    {
        $price = $product->display_price !== null ? (float) $product->display_price : null;
        $comparePrice = $product->compare_price !== null ? (float) $product->compare_price : null;
        $rating = round((float) ($product->average_rating ?? 0), 1);
        $isInStock = (int) ($product->active_variants_count ?? 0) > 0;

        $item = [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'short_description' => $product->short_description,
            'price' => $price,
            'compare_price' => $comparePrice,
            'badge' => $this->buildBadge($product),
            'rating' => $rating,
            'rating_count' => (int) ($product->rating_count ?? 0),
            'in_stock' => $isInStock,
            'status' => (bool) $product->status,
            'caffeine' => $product->caffeine,
            'collection' => $this->splitCollectionValues($product->collection),
            'images' => [
                'image_1' => $product->resolveMediaUrl($product->cart_image_1),
                'image_2' => $product->resolveMediaUrl($product->cart_image_2),
            ],
        ];

        if (in_array('category', $includes, true)) {
            $item['category'] = $product->category ? [
                'id' => $product->category->id,
                'name' => $product->category->name,
                'slug' => $product->category->slug,
            ] : null;
        }

        if (in_array('subcategory', $includes, true)) {
            $item['subcategory'] = $product->subcategory ? [
                'id' => $product->subcategory->id,
                'name' => $product->subcategory->name,
                'slug' => $product->subcategory->slug,
                'category_id' => $product->subcategory->parent_id,
            ] : null;
        }

        if (in_array('variants', $includes, true)) {
            $item['variants'] = $product->variants->map(function (ProductVariant $variant) {
                $effectivePrice = $variant->discount_price !== null && (float) $variant->discount_price > 0 && (float) $variant->discount_price < (float) $variant->price
                    ? (float) $variant->discount_price
                    : (float) $variant->price;

                return [
                    'id' => $variant->id,
                    'name' => $variant->name,
                    'price' => $effectivePrice,
                    'compare_price' => $variant->price !== null ? (float) $variant->price : null,
                    'product_dimension' => $variant->product_dimension,
                    'item_form' => $variant->item_form,
                ];
            })->values()->all();
        }

        return $item;
    }

    private function applyCatalogSorting(Builder $query, string $sort, string $search = ''): void
    {
        $sort = strtolower(trim($sort));

        match ($sort) {
            'newest' => $query->latest('products.created_at'),
            'price_asc' => $query->orderBy('display_price')->orderByDesc('products.created_at'),
            'price_desc' => $query->orderByDesc('display_price')->orderByDesc('products.created_at'),
            'rating_desc' => $query->orderByDesc('average_rating')->orderByDesc('products.created_at'),
            'best_selling' => $query->orderByDesc('total_sold')->orderByDesc('products.created_at'),
            default => $this->applyRelevanceSorting($query, $search),
        };
    }

    private function applyRelevanceSorting(Builder $query, string $search = ''): void
    {
        if ($search !== '') {
            $escaped = addcslashes($search, '%_');
            $query->orderByRaw(
                'CASE
                    WHEN products.name LIKE ? THEN 1
                    WHEN products.name LIKE ? THEN 2
                    WHEN products.tag_line_1 LIKE ? THEN 3
                    WHEN products.tag_line_2 LIKE ? THEN 4
                    ELSE 5
                END',
                [$escaped, "%{$escaped}%", "%{$escaped}%", "%{$escaped}%"]
            );
        }

        $query->orderByDesc('products.created_at');
    }

    private function applyTagFilter(Builder $query, string $tag): void
    {
        $normalizedTag = strtolower(trim($tag));

        if ($normalizedTag === 'bestseller') {
            $query->havingRaw('COALESCE(total_sold, 0) > 0');

            return;
        }

        if ($normalizedTag === 'new') {
            $query->where('products.created_at', '>=', now()->subDays(30));

            return;
        }

        if (preg_match('/(\d+)\s*%\s*off/', $normalizedTag, $matches)) {
            $discountPercent = (int) $matches[1];

            $query->whereHas('variants', function ($variantQuery) use ($discountPercent) {
                $variantQuery->where('status', true)
                    ->whereNotNull('discount_price')
                    ->whereColumn('discount_price', '<', 'price')
                    ->whereRaw('ROUND(((price - discount_price) / price) * 100) = ?', [$discountPercent]);
            });

            return;
        }

        $query->whereRaw('1 = 0');
    }

    private function buildBadge(Product $product): ?string
    {
        $price = $product->display_price !== null ? (float) $product->display_price : null;
        $comparePrice = $product->compare_price !== null ? (float) $product->compare_price : null;

        if ($price !== null && $comparePrice !== null && $comparePrice > $price && $comparePrice > 0) {
            $discountPercent = (int) round((($comparePrice - $price) / $comparePrice) * 100);

            if ($discountPercent > 0) {
                return $discountPercent.'% OFF';
            }
        }

        if ((int) ($product->total_sold ?? 0) > 0) {
            return 'Bestseller';
        }

        if ($product->created_at?->gte(now()->subDays(30))) {
            return 'New';
        }

        return null;
    }

    private function parseIncludes(null|string|array $includes): array
    {
        if (is_array($includes)) {
            $includes = implode(',', $includes);
        }

        return collect(explode(',', (string) $includes))
            ->map(fn ($include) => trim((string) $include))
            ->filter(fn ($include) => in_array($include, ['variants', 'category', 'subcategory'], true))
            ->unique()
            ->values()
            ->all();
    }

    private function resolveCategoryIdentifier(mixed $value, bool $isSubcategory): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_numeric($value)) {
            return Category::query()
                ->when($isSubcategory, fn ($query) => $query->whereNotNull('parent_id'), fn ($query) => $query->whereNull('parent_id'))
                ->where('id', (int) $value)
                ->value('id');
        }

        return Category::query()
            ->when($isSubcategory, fn ($query) => $query->whereNotNull('parent_id'), fn ($query) => $query->whereNull('parent_id'))
            ->where('slug', trim((string) $value))
            ->value('id');
    }

    private function splitCollectionValues(null|string|array $collection): array
    {
        if (is_array($collection)) {
            return collect($collection)
                ->map(fn ($item) => trim((string) $item))
                ->filter()
                ->values()
                ->all();
        }

        return collect(explode(',', (string) $collection))
            ->map(fn ($item) => trim((string) $item))
            ->filter()
            ->values()
            ->all();
    }

    private function transformPublicProduct(Product $product): array
    {
        $activeVariants = $product->variants->values();
        $selectedVariant = $activeVariants->firstWhere('is_default', true) ?? $activeVariants->first();

        return [
            'id' => $product->id,
            'tag_line_1' => $product->tag_line_1,
            'name' => $product->name,
            'slug' => $product->slug,
            'tag_line_2' => $product->tag_line_2,
            'short_description' => $product->short_description,
            'description' => $product->description,
            'caffeine' => $product->caffeine,
            'collection' => $product->collection,
            'category' => [
                'id' => $product->category?->id,
            ],
            'subcategory' => [
                'id' => $product->subcategory?->id,
            ],
            'images' => collect($product->gallery)
                ->filter()
                ->values()
                ->map(fn (array $image, int $index) => [
                    'name' => $product->name.' Image '.($index + 1),
                    'image_url' => $image['image_url'] ?? null,
                ])
                ->filter(fn (array $image) => ! empty($image['image_url']))
                ->values()
                ->all(),
            'ingredients' => $product->ingredients,
            'faqs' => $this->transformFaqs($product),
            'variants' => $activeVariants->map(fn (ProductVariant $variant) => $this->transformVariant($variant))->all(),
            'default_variant_id' => $selectedVariant?->id,
            'price' => $selectedVariant?->price !== null ? (float) $selectedVariant->price : null,
            'discount_price' => $selectedVariant?->discount_price !== null ? (float) $selectedVariant->discount_price : null,
            'compare_price' => $selectedVariant?->discount_price !== null ? (float) $selectedVariant->discount_price : null,
            'currency' => 'INR',
            'brewing_rituals' => $this->transformBrewingRituals($product),
            'brewing_rituals_note' => trim((string) data_get($product->brewing_rituals, 'note', '')),
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
            'short_description' => $payload['short_description'] ?? $product?->short_description,
            'description' => $payload['description'] ?? $product?->description,
            'caffeine' => $payload['caffeine'] ?? $product?->caffeine,
            'collection' => $this->normalizeCollection($payload['collection'] ?? $product?->collection),
            'ingredients' => array_key_exists('ingredients', $payload)
                ? (trim((string) $payload['ingredients']) ?: null)
                : $product?->ingredients,
            'faqs' => $payload['faqs'] ?? $product?->faqs ?? [],
            'brewing_rituals' => $this->prepareBrewingRituals($payload['brewing_rituals'] ?? ($product?->brewing_rituals ?? [])),
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

        foreach (range(1, 2) as $index) {
            $column = 'cart_image_'.$index;

            if (array_key_exists($column, $payload)) {
                $data[$column] = $this->storeOptionalFile($payload[$column], 'products/cart', $product?->{$column});
            } elseif ($product !== null) {
                $data[$column] = $product->{$column};
            }
        }

        return $data;
    }

    private function normalizeCollection(null|string|array $collection): ?string
    {
        if (is_array($collection)) {
            $collection = implode(', ', $collection);
        }

        $items = collect(explode(',', (string) $collection))
            ->map(fn ($item) => trim((string) $item))
            ->filter()
            ->values();

        return $items->isNotEmpty() ? $items->implode(', ') : null;
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
            'product_dimension' => $variantData['product_dimension'] ?? null,
            'item_form' => $variantData['item_form'] ?? null,
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
            'product_dimension' => $variant->product_dimension,
            'item_form' => $variant->item_form,
            'is_default' => (bool) $variant->is_default,
            'status' => (bool) $variant->status,
            'primary_image' => $variant->primary_image ? [
                'image_url' => $variant->primary_image['image_url'] ?? null,
            ] : null,
        ];
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

    private function transformBrewingRituals(Product $product): array
    {
        $ritualGroups = $this->normalizeBrewingRitualGroups($product->brewing_rituals ?? []);

        return collect([
            'hot_brew' => 'Hot Brew',
            'iced_brew' => 'Iced Brew',
        ])
            ->map(function (string $title, string $group) use ($ritualGroups) {
                $items = collect($ritualGroups[$group] ?? [])
                    ->filter(fn ($ritual) => is_array($ritual))
                    ->map(function (array $ritual) {
                        $label = trim((string) ($ritual['label'] ?? ''));
                        $value = trim((string) ($ritual['value'] ?? $ritual['ritual'] ?? $ritual['text'] ?? ''));

                        return ($label !== '' || $value !== '') ? [
                            'label' => $label,
                            'value' => $value,
                        ] : null;
                    })
                    ->filter()
                    ->values()
                    ->all();

                return [
                    'key' => $group,
                    'title' => $title,
                    'items' => $items,
                ];
            })
            ->filter(fn (?array $ritual) => $ritual !== null && ! empty($ritual['items']))
            ->values()
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

    private function transformSearchProduct(Product $product): array
    {
        $variant = $product->variants->first();

        return [
            'id' => $product->id,
            'name' => $product->name,
            'variant_name' => $variant?->name,
            'img' => $variant?->primary_image['image_url']
                ?? collect($product->gallery)->first()['image_url']
                ?? null,
            'slug' => $product->slug,
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

        foreach (range(1, 2) as $index) {
            $path = $product->{'cart_image_'.$index};

            if ($path && ! preg_match('/^https?:\/\//i', $path)) {
                Storage::disk('public')->delete($path);
            }
        }

        foreach ($this->flattenBrewingRituals($product->brewing_rituals ?? []) as $ritual) {
            $path = $ritual['image'] ?? null;

            if ($path && ! preg_match('/^https?:\/\//i', $path)) {
                Storage::disk('public')->delete($path);
            }
        }

        foreach ($product->variants as $variant) {
            foreach ($this->flattenBrewingRituals($variant->brewing_rituals ?? []) as $ritual) {
                $path = $ritual['image'] ?? null;

                if ($path && ! preg_match('/^https?:\/\//i', $path)) {
                    Storage::disk('public')->delete($path);
                }
            }
        }
    }

    private function prepareBrewingRituals(array $rituals): array
    {
        $ritualGroups = $this->normalizeBrewingRitualGroups($rituals);

        $prepared = collect(['hot_brew', 'iced_brew'])
            ->mapWithKeys(fn (string $group) => [
                $group => collect($ritualGroups[$group] ?? [])
            ->filter(fn ($ritual) => is_array($ritual))
            ->values()
            ->map(fn (array $ritual) => [
                'label' => trim((string) ($ritual['label'] ?? '')),
                'value' => trim((string) ($ritual['value'] ?? $ritual['ritual'] ?? $ritual['text'] ?? '')),
            ])
            ->filter(fn ($ritual) => $ritual['label'] !== '' || $ritual['value'] !== '')
            ->values()
            ->all(),
            ])
            ->all();

        $prepared['note'] = trim((string) ($rituals['note'] ?? ''));

        return $prepared;
    }

    private function normalizeBrewingRitualGroups(array $rituals): array
    {
        if (array_key_exists('hot_brew', $rituals) || array_key_exists('iced_brew', $rituals)) {
            return [
                'hot_brew' => is_array($rituals['hot_brew'] ?? null) ? $rituals['hot_brew'] : [],
                'iced_brew' => is_array($rituals['iced_brew'] ?? null) ? $rituals['iced_brew'] : [],
                'note' => trim((string) ($rituals['note'] ?? '')),
            ];
        }

        return [
            'hot_brew' => array_values(array_filter([$rituals[0] ?? null], fn ($ritual) => is_array($ritual))),
            'iced_brew' => array_values(array_filter([$rituals[1] ?? null], fn ($ritual) => is_array($ritual))),
            'note' => '',
        ];
    }

    private function flattenBrewingRituals(array $rituals): array
    {
        $groups = $this->normalizeBrewingRitualGroups($rituals);

        return array_merge($groups['hot_brew'], $groups['iced_brew']);
    }
}
