<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\UploadedFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends BaseAdminController
{
    public function index(Request $request): View
    {
        $filters = $request->only(['q', 'category_id', 'status', 'page']);
        $productResponse = $this->apiService->get('products', array_filter([
            'search' => $filters['q'] ?? null,
            'category' => $filters['category_id'] ?? null,
            'status' => $filters['status'] ?? null,
            'page' => $filters['page'] ?? null,
            'limit' => 20,
            'include' => 'category,variants',
        ], fn ($value) => $value !== null && $value !== ''));

        return view('admin.products.index', [
            'products' => $this->normalizeProductListing($productResponse['data'] ?? []),
            'categories' => $this->apiService->get('categories', ['include_inactive' => 1])['data'] ?? [],
            'filters' => $filters,
        ]);
    }

    public function create(): View
    {
        return view('admin.products.create', [
            'product' => null,
            'categories' => $this->apiService->get('categories', ['include_inactive' => 1])['data'] ?? [],
        ]);
    }

    public function show(int $product): View
    {
        $productResponse = $this->apiService->get("admin/products/{$product}");
        abort_unless($productResponse['ok'], 404);

        return view('admin.products.show', [
            'product' => $productResponse['data'],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $payload = $this->payload($request);
        $response = $this->apiService->postMultipart('products', $payload, $request->allFiles());

        if (! $response['ok']) {
            return $this->backWithApiError($response, 'Unable to create product.');
        }

        return redirect()->route('admin.products.edit', $response['data']['id'] ?? null)->with('success', $response['message'] ?: 'Product created successfully.');
    }

    public function edit(int $product): View
    {
        $productResponse = $this->apiService->get("admin/products/{$product}");
        abort_unless($productResponse['ok'], 404);

        return view('admin.products.edit', [
            'product' => $productResponse['data'],
            'categories' => $this->apiService->get('categories', ['include_inactive' => 1])['data'] ?? [],
        ]);
    }

    public function update(Request $request, int $product): RedirectResponse
    {
        $payload = $this->payload($request, true);
        $response = $this->apiService->putMultipart("products/{$product}", $payload, $request->allFiles());

        if (! $response['ok']) {
            return $this->backWithApiError($response, 'Unable to update product.');
        }

        return redirect()->route('admin.products.edit', $product)->with('success', $response['message'] ?: 'Product updated successfully.');
    }

    public function destroy(int $product): RedirectResponse
    {
        $response = $this->apiService->delete("products/{$product}");

        if (! $response['ok']) {
            return back()->with('error', $response['message'] ?: 'Unable to delete product.');
        }

        return redirect()->route('admin.products.index')->with('success', $response['message'] ?: 'Product deleted successfully.');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $payload = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer'],
        ]);

        $failures = collect($payload['ids'])->map(function ($id) {
            $response = $this->apiService->delete("products/{$id}");

            return $response['ok'] ? null : ($response['message'] ?: "Product {$id} failed");
        })->filter()->values();

        if ($failures->isNotEmpty()) {
            return back()->with('error', 'Some products could not be deleted: '.$failures->implode(', '));
        }

        return redirect()->route('admin.products.index')->with('success', 'Selected products deleted successfully.');
    }

    private function payload(Request $request, bool $updating = false): array
    {
        $validated = $request->validate([
            'category_id' => ['nullable'],
            'subcategory_id' => ['nullable'],
            'tag_line_1' => ['nullable', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'tag_line_2' => ['nullable', 'string', 'max:255'],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'caffeine' => ['nullable', 'in:low,medium,caffeine_free'],
            'collection' => ['nullable', 'string'],
            'image_1' => ['nullable', 'file', 'image', 'max:5120'],
            'image_2' => ['nullable', 'file', 'image', 'max:5120'],
            'image_3' => ['nullable', 'file', 'image', 'max:5120'],
            'image_4' => ['nullable', 'file', 'image', 'max:5120'],
            'image_5' => ['nullable', 'file', 'image', 'max:5120'],
            'ingredients' => ['nullable', 'string'],
            'faqs' => ['nullable', 'array'],
            'faqs.*.question' => ['nullable', 'string'],
            'faqs.*.answer' => ['nullable', 'string'],
            'brewing_rituals' => ['nullable', 'array'],
            'brewing_rituals.note' => ['nullable', 'string'],
            'brewing_rituals.hot_brew' => ['nullable', 'array'],
            'brewing_rituals.hot_brew.*.label' => ['nullable', 'string', 'max:255'],
            'brewing_rituals.hot_brew.*.value' => ['nullable', 'string', 'max:255'],
            'brewing_rituals.iced_brew' => ['nullable', 'array'],
            'brewing_rituals.iced_brew.*.label' => ['nullable', 'string', 'max:255'],
            'brewing_rituals.iced_brew.*.value' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable'],
            'variants' => ['required', 'array', 'min:1'],
            'variants.*.id' => [$updating ? 'nullable' : 'sometimes'],
            'variants.*.name' => ['required', 'string', 'max:255'],
            'variants.*.sku' => ['required', 'string', 'max:100'],
            'variants.*.price' => ['required', 'numeric', 'min:0'],
            'variants.*.discount_price' => ['nullable', 'numeric', 'min:0'],
            'variants.*.weight' => ['nullable', 'string', 'max:255'],
            'variants.*.product_dimension' => ['nullable', 'string', 'max:255'],
            'variants.*.item_form' => ['nullable', 'string', 'max:255'],
            'variants.*.is_default' => ['nullable'],
            'variants.*.status' => ['nullable'],
        ]);

        $validated['category_id'] = ($validated['category_id'] ?? null) ?: null;
        $validated['subcategory_id'] = ($validated['subcategory_id'] ?? null) ?: null;
        $validated['status'] = $request->boolean('status');
        $validated['caffeine'] = ($validated['caffeine'] ?? null) ?: null;
        $validated['collection'] = collect(explode(',', (string) ($validated['collection'] ?? '')))
            ->map(fn ($item) => trim((string) $item))
            ->filter()
            ->implode(', ') ?: null;

        $validated['ingredients'] = trim((string) ($validated['ingredients'] ?? '')) ?: null;

        $validated['faqs'] = collect($validated['faqs'] ?? [])
            ->map(fn ($faq) => [
                'question' => trim((string) ($faq['question'] ?? '')),
                'answer' => trim((string) ($faq['answer'] ?? '')),
            ])
            ->filter(fn ($faq) => $faq['question'] !== '' || $faq['answer'] !== '')
            ->values()
            ->all();

        $validated['brewing_rituals'] = collect(['hot_brew', 'iced_brew'])
            ->mapWithKeys(function (string $group) use ($validated) {
                $rituals = collect($validated['brewing_rituals'][$group] ?? [])
                    ->map(fn ($ritual) => [
                        'label' => trim((string) ($ritual['label'] ?? '')),
                        'value' => trim((string) ($ritual['value'] ?? '')),
                    ])
                    ->filter(fn ($ritual) => $ritual['label'] !== '' || $ritual['value'] !== '')
                    ->values()
                    ->all();

                return [$group => $rituals];
            })
            ->all();
        $validated['brewing_rituals']['note'] = trim((string) $request->input('brewing_rituals.note', ''));

        $validated['variants'] = collect($validated['variants'])->map(function ($variant, $index) use ($request) {
            $variant['discount_price'] = isset($variant['discount_price']) && $variant['discount_price'] !== '' ? (float) $variant['discount_price'] : null;
            $variant['status'] = $request->boolean("variants.{$index}.status");
            $variant['is_default'] = $request->boolean("variants.{$index}.is_default");

            return $variant;
        })->values()->all();

        return $validated;
    }

    private function validateOptionalImageValue(string $attribute, mixed $value, \Closure $fail): void
    {
        if ($value === null || $value === '') {
            return;
        }

        if (is_string($value)) {
            return;
        }

        if (! $value instanceof UploadedFile) {
            $fail("The {$attribute} field must be an image.");

            return;
        }

        if (! str_starts_with((string) $value->getMimeType(), 'image/')) {
            $fail("The {$attribute} field must be an image.");

            return;
        }

        if ($value->getSize() > 5 * 1024 * 1024) {
            $fail("The {$attribute} field must not be greater than 5120 kilobytes.");
        }
    }

    private function normalizeProductListing(mixed $payload): array
    {
        if (! is_array($payload) || ! array_key_exists('items', $payload) || ! array_key_exists('pagination', $payload)) {
            return is_array($payload) ? $payload : [];
        }

        $pagination = $payload['pagination'];
        $currentPage = max(1, (int) ($pagination['page'] ?? 1));
        $lastPage = max(1, (int) ($pagination['total_pages'] ?? 1));

        return [
            'data' => $payload['items'] ?? [],
            'current_page' => $currentPage,
            'last_page' => $lastPage,
            'per_page' => (int) ($pagination['limit'] ?? 20),
            'total' => (int) ($pagination['total_items'] ?? count($payload['items'] ?? [])),
            'links' => $this->buildPaginationLinks($currentPage, $lastPage),
        ];
    }

    private function buildPaginationLinks(int $currentPage, int $lastPage): array
    {
        $links = [[
            'url' => $currentPage > 1 ? request()->fullUrlWithQuery(['page' => $currentPage - 1]) : null,
            'label' => '&laquo; Previous',
            'active' => false,
        ]];

        for ($page = 1; $page <= $lastPage; $page++) {
            $links[] = [
                'url' => request()->fullUrlWithQuery(['page' => $page]),
                'label' => (string) $page,
                'active' => $page === $currentPage,
            ];
        }

        $links[] = [
            'url' => $currentPage < $lastPage ? request()->fullUrlWithQuery(['page' => $currentPage + 1]) : null,
            'label' => 'Next &raquo;',
            'active' => false,
        ];

        return $links;
    }
}
