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

    private function payload(Request $request, bool $updating = false): array
    {
        $validated = $request->validate([
            'category_id' => ['nullable'],
            'subcategory_id' => ['nullable'],
            'tag_line_1' => ['nullable', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'tag_line_2' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image_1' => ['nullable', 'file', 'image', 'max:5120'],
            'image_2' => ['nullable', 'file', 'image', 'max:5120'],
            'image_3' => ['nullable', 'file', 'image', 'max:5120'],
            'image_4' => ['nullable', 'file', 'image', 'max:5120'],
            'image_5' => ['nullable', 'file', 'image', 'max:5120'],
            'ingredients' => ['nullable', 'array'],
            'ingredients.*.name' => ['nullable', 'string', 'max:255'],
            'ingredients.*.image' => ['nullable', 'file', 'image', 'max:5120'],
            'faqs' => ['nullable', 'array'],
            'faqs.*.question' => ['nullable', 'string'],
            'faqs.*.answer' => ['nullable', 'string'],
            'status' => ['nullable'],
            'variants' => ['required', 'array', 'min:1'],
            'variants.*.id' => [$updating ? 'nullable' : 'sometimes'],
            'variants.*.name' => ['required', 'string', 'max:255'],
            'variants.*.sku' => ['required', 'string', 'max:100'],
            'variants.*.price' => ['required', 'numeric', 'min:0'],
            'variants.*.discount_price' => ['nullable', 'numeric', 'min:0'],
            'variants.*.weight' => ['nullable', 'string', 'max:255'],
            'variants.*.brewing_rituals' => ['nullable', 'array'],
            'variants.*.brewing_rituals.*.ritual' => ['nullable', 'string', 'max:255'],
            'variants.*.brewing_rituals.*.image' => ['nullable', 'file', 'image', 'max:5120'],
            'variants.*.is_default' => ['nullable'],
            'variants.*.status' => ['nullable'],
        ]);

        $validated['category_id'] = $validated['category_id'] ?: null;
        $validated['subcategory_id'] = $validated['subcategory_id'] ?: null;
        $validated['status'] = $request->boolean('status');

        $validated['ingredients'] = collect($validated['ingredients'] ?? [])
            ->map(function ($ingredient, $index) use ($request) {
                $image = $request->file("ingredients.{$index}.image");
                $current = $request->input("ingredients.{$index}.existing_image");

                return [
                    'name' => trim((string) ($ingredient['name'] ?? '')),
                    'image' => $image ?: ($current ?: null),
                ];
            })
            ->filter(fn ($ingredient) => $ingredient['name'] !== '' || $ingredient['image'] !== null)
            ->values()
            ->all();

        $validated['faqs'] = collect($validated['faqs'] ?? [])
            ->map(fn ($faq) => [
                'question' => trim((string) ($faq['question'] ?? '')),
                'answer' => trim((string) ($faq['answer'] ?? '')),
            ])
            ->filter(fn ($faq) => $faq['question'] !== '' || $faq['answer'] !== '')
            ->values()
            ->all();

        $validated['variants'] = collect($validated['variants'])->map(function ($variant, $index) use ($request) {
            $variant['discount_price'] = isset($variant['discount_price']) && $variant['discount_price'] !== '' ? (float) $variant['discount_price'] : null;
            $variant['brewing_rituals'] = collect($variant['brewing_rituals'] ?? [])
                ->map(function ($ritual, $ritualIndex) use ($request, $index) {
                    $image = $request->file("variants.{$index}.brewing_rituals.{$ritualIndex}.image");
                    $current = $request->input("variants.{$index}.brewing_rituals.{$ritualIndex}.existing_image");

                    return [
                        'ritual' => trim((string) ($ritual['ritual'] ?? '')),
                        'image' => $image ?: ($current ?: null),
                    ];
                })
                ->filter(fn ($ritual) => $ritual['ritual'] !== '' || $ritual['image'] !== null)
                ->values()
                ->all();
            $variant['status'] = $request->boolean("variants.{$index}.status");
            $variant['is_default'] = $request->boolean("variants.{$index}.is_default");

            return $variant;
        })->values()->all();

        return $validated;
    }
}
