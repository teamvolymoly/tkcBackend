<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends BaseAdminController
{
    public function index(Request $request): View
    {
        $filters = $request->only(['q', 'category_id', 'status', 'page']);

        return view('admin.products.index', [
            'products' => $this->apiService->get('products', array_filter($filters, fn ($value) => $value !== null && $value !== ''))['data'] ?? [],
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

    public function storeVariantImage(Request $request, int $product, int $variant): RedirectResponse
    {
        $payload = $request->validate([
            'image' => ['required', 'file', 'image', 'max:5120'],
            'is_primary' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $response = $this->apiService->postMultipart('variant-images', [
            'variant_id' => $variant,
            'is_primary' => $request->boolean('is_primary'),
            'sort_order' => $payload['sort_order'] ?? 0,
        ], [
            'image' => $request->file('image'),
        ]);

        if (! $response['ok']) {
            return $this->backWithApiError($response, 'Unable to add variant image.');
        }

        return back()->with('success', $response['message'] ?: 'Variant image added successfully.');
    }

    public function updateVariantImage(Request $request, int $product, int $variant, int $image): RedirectResponse
    {
        $payload = $request->validate([
            'image' => ['nullable', 'file', 'image', 'max:5120'],
            'is_primary' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $response = $this->apiService->putMultipart("variant-images/{$image}", [
            'is_primary' => $request->boolean('is_primary'),
            'sort_order' => $payload['sort_order'] ?? 0,
        ], [
            'image' => $request->file('image'),
        ]);

        if (! $response['ok']) {
            return $this->backWithApiError($response, 'Unable to update variant image.');
        }

        return back()->with('success', $response['message'] ?: 'Variant image updated successfully.');
    }

    public function destroyVariantImage(int $product, int $variant, int $image): RedirectResponse
    {
        $response = $this->apiService->delete("variant-images/{$image}");

        if (! $response['ok']) {
            return back()->with('error', $response['message'] ?: 'Unable to delete variant image.');
        }

        return back()->with('success', $response['message'] ?: 'Variant image deleted successfully.');
    }

    public function storeIngredient(Request $request, int $product): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'value' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'file', 'image', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $response = $this->apiService->postMultipart("products/{$product}/ingredients", [
            'name' => $validated['name'],
            'value' => $validated['value'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
        ], [
            'image' => $request->file('image'),
        ]);

        if (! $response['ok']) {
            return $this->backWithApiError($response, 'Unable to add ingredient.');
        }

        return back()->with('success', $response['message'] ?: 'Ingredient added successfully.');
    }

    public function updateIngredient(Request $request, int $product, int $ingredient): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'value' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'file', 'image', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $response = $this->apiService->putMultipart("ingredients/{$ingredient}", [
            'name' => $validated['name'],
            'value' => $validated['value'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
        ], [
            'image' => $request->file('image'),
        ]);

        if (! $response['ok']) {
            return $this->backWithApiError($response, 'Unable to update ingredient.');
        }

        return back()->with('success', $response['message'] ?: 'Ingredient updated successfully.');
    }

    public function destroyIngredient(int $product, int $ingredient): RedirectResponse
    {
        $response = $this->apiService->delete("ingredients/{$ingredient}");

        if (! $response['ok']) {
            return back()->with('error', $response['message'] ?: 'Unable to delete ingredient.');
        }

        return back()->with('success', $response['message'] ?: 'Ingredient deleted successfully.');
    }

    public function storeNutrition(Request $request, int $product): RedirectResponse
    {
        $response = $this->apiService->post("products/{$product}/nutrition", $request->validate([
            'nutrient' => ['required', 'string', 'max:255'],
            'value' => ['required', 'string', 'max:255'],
            'unit' => ['nullable', 'string', 'max:50'],
        ]));

        if (! $response['ok']) {
            return $this->backWithApiError($response, 'Unable to add nutrition row.');
        }

        return back()->with('success', $response['message'] ?: 'Nutrition added successfully.');
    }

    public function updateNutrition(Request $request, int $product, int $nutrition): RedirectResponse
    {
        $response = $this->apiService->put("nutrition/{$nutrition}", $request->validate([
            'nutrient' => ['required', 'string', 'max:255'],
            'value' => ['required', 'string', 'max:255'],
            'unit' => ['nullable', 'string', 'max:50'],
        ]));

        if (! $response['ok']) {
            return $this->backWithApiError($response, 'Unable to update nutrition row.');
        }

        return back()->with('success', $response['message'] ?: 'Nutrition updated successfully.');
    }

    public function destroyNutrition(int $product, int $nutrition): RedirectResponse
    {
        $response = $this->apiService->delete("nutrition/{$nutrition}");

        if (! $response['ok']) {
            return back()->with('error', $response['message'] ?: 'Unable to delete nutrition row.');
        }

        return back()->with('success', $response['message'] ?: 'Nutrition deleted successfully.');
    }

    private function payload(Request $request, bool $updating = false): array
    {
        $validated = $request->validate([
            'category_id' => ['nullable'],
            'subcategory_id' => ['nullable'],
            'name' => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string'],
            'allergic_information' => ['nullable', 'string'],
            'tea_type' => ['nullable', 'string', 'max:100'],
            'disclaimer' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'ingredients' => ['nullable', 'string'],
            'features' => ['nullable', 'array'],
            'features.*.icon' => ['nullable', 'string', 'max:100'],
            'features.*.text' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable'],
            'variants' => ['required', 'array', 'min:1'],
            'variants.*.id' => [$updating ? 'nullable' : 'sometimes'],
            'variants.*.variant_name' => ['nullable', 'string', 'max:255'],
            'variants.*.size' => ['nullable', 'string', 'max:100'],
            'variants.*.color' => ['nullable', 'string', 'max:100'],
            'variants.*.sku' => ['required', 'string', 'max:100'],
            'variants.*.price' => ['required', 'numeric', 'min:0'],
            'variants.*.compare_price' => ['nullable', 'numeric', 'min:0'],
            'variants.*.stock' => ['nullable', 'integer', 'min:0'],
            'variants.*.weight' => ['nullable', 'numeric', 'min:0'],
            'variants.*.dimensions' => ['nullable', 'string', 'max:255'],
            'variants.*.net_weight' => ['nullable', 'string', 'max:255'],
            'variants.*.tags_raw' => ['nullable', 'string'],
            'variants.*.brewing_rituals' => ['nullable', 'array'],
            'variants.*.brewing_rituals.*.group' => ['nullable', 'string', 'max:100'],
            'variants.*.brewing_rituals.*.title' => ['nullable', 'string', 'max:100'],
            'variants.*.brewing_rituals.*.icon' => ['nullable', 'string', 'max:100'],
            'variants.*.brewing_rituals.*.text' => ['nullable', 'string', 'max:255'],
            'variants.*.brewing_rituals.*.value' => ['nullable', 'string', 'max:255'],
            'variants.*.images' => ['nullable', 'array'],
            'variants.*.images.*.id' => ['nullable'],
            'variants.*.images.*.file' => ['nullable', 'file', 'image', 'max:5120'],
            'variants.*.images.*.is_primary' => ['nullable'],
            'variants.*.images.*.sort_order' => ['nullable', 'integer', 'min:0'],
            'variants.*.status' => ['nullable'],
        ]);

        $validated['category_id'] = $validated['category_id'] ?: null;
        $validated['subcategory_id'] = $validated['subcategory_id'] ?: null;
        $validated['status'] = $request->boolean('status');
        $validated['features'] = collect($validated['features'] ?? [])
            ->map(fn ($feature) => [
                'icon' => trim((string) ($feature['icon'] ?? '')),
                'text' => trim((string) ($feature['text'] ?? '')),
            ])
            ->filter(fn ($feature) => $feature['icon'] !== '' || $feature['text'] !== '')
            ->values()
            ->all();

        $validated['variants'] = collect($validated['variants'])->map(function ($variant, $index) use ($request) {
            $variant['stock'] = (int) ($variant['stock'] ?? 0);
            $variant['compare_price'] = isset($variant['compare_price']) && $variant['compare_price'] !== '' ? (float) $variant['compare_price'] : null;
            $variant['tags'] = collect(preg_split('/\s*,\s*/', (string) ($variant['tags_raw'] ?? ''), -1, PREG_SPLIT_NO_EMPTY))->values()->all();
            unset($variant['tags_raw']);
            $variant['brewing_rituals'] = collect($variant['brewing_rituals'] ?? [])
                ->map(fn ($ritual) => [
                    'group' => trim((string) ($ritual['group'] ?? '')),
                    'title' => trim((string) ($ritual['title'] ?? '')),
                    'icon' => trim((string) ($ritual['icon'] ?? '')),
                    'text' => trim((string) ($ritual['text'] ?? '')),
                    'value' => trim((string) ($ritual['value'] ?? '')),
                ])
                ->filter(fn ($ritual) => collect($ritual)->some(fn ($value) => $value !== ''))
                ->values()
                ->all();
            $variant['status'] = $request->boolean("variants.{$index}.status");
            $variant['is_default'] = $request->boolean("variants.{$index}.is_default");
            $variant['images'] = collect($variant['images'] ?? [])
                ->map(function ($image, $imageIndex) use ($request, $index) {
                    $file = $request->file("variants.{$index}.images.{$imageIndex}.file");
                    $imageId = $image['id'] ?? null;

                    if (! $file && ! $imageId && ($image['sort_order'] ?? null) === null && ! $request->boolean("variants.{$index}.images.{$imageIndex}.is_primary")) {
                        return null;
                    }

                    return [
                        'id' => $imageId,
                        'file' => $file,
                        'is_primary' => $request->boolean("variants.{$index}.images.{$imageIndex}.is_primary"),
                        'sort_order' => isset($image['sort_order']) ? (int) $image['sort_order'] : null,
                    ];
                })
                ->filter()
                ->values()
                ->all();

            return $variant;
        })->values()->all();

        return $validated;
    }
}
