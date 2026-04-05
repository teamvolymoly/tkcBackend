<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends BaseAdminController
{
    public function index(Request $request): View
    {
        return view('admin.categories.index', [
            'categories' => $this->apiService->get('categories', ['include_inactive' => 1])['data'] ?? [],
            'filters' => $request->only('q'),
        ]);
    }

    public function create(): View
    {
        return view('admin.categories.create', [
            'categories' => $this->apiService->get('categories', ['include_inactive' => 1])['data'] ?? [],
            'category' => null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $response = $this->apiService->postMultipart('categories', $this->payload($request), [
            'image' => $request->file('image'),
        ]);

        if (! $response['ok']) {
            return $this->backWithApiError($response, 'Unable to create category.');
        }

        return redirect()->route('admin.categories.index')->with('success', $response['message'] ?: 'Category created successfully.');
    }

    public function edit(int $category): View
    {
        $categoryResponse = $this->apiService->get("categories/{$category}");
        abort_unless($categoryResponse['ok'], 404);

        return view('admin.categories.edit', [
            'categories' => $this->apiService->get('categories', ['include_inactive' => 1])['data'] ?? [],
            'category' => $categoryResponse['data'],
        ]);
    }

    public function update(Request $request, int $category): RedirectResponse
    {
        $response = $this->apiService->putMultipart("categories/{$category}", $this->payload($request), [
            'image' => $request->file('image'),
        ]);

        if (! $response['ok']) {
            return $this->backWithApiError($response, 'Unable to update category.');
        }

        return redirect()->route('admin.categories.index')->with('success', $response['message'] ?: 'Category updated successfully.');
    }

    public function destroy(int $category): RedirectResponse
    {
        $response = $this->apiService->delete("categories/{$category}");

        if (! $response['ok']) {
            return back()->with('error', $response['message'] ?: 'Unable to delete category.');
        }

        return redirect()->route('admin.categories.index')->with('success', $response['message'] ?: 'Category deleted successfully.');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $payload = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer'],
        ]);

        $failures = collect($payload['ids'])->map(function ($id) {
            $response = $this->apiService->delete("categories/{$id}");

            return $response['ok'] ? null : ($response['message'] ?: "Category {$id} failed");
        })->filter()->values();

        if ($failures->isNotEmpty()) {
            return back()->with('error', 'Some categories could not be deleted: '.$failures->implode(', '));
        }

        return redirect()->route('admin.categories.index')->with('success', 'Selected categories deleted successfully.');
    }

    private function payload(Request $request): array
    {
        $payload = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'file', 'image', 'max:5120'],
            'parent_id' => ['nullable'],
            'status' => ['nullable'],
        ]);

        $payload['parent_id'] = $payload['parent_id'] ?: null;
        $payload['status'] = $request->boolean('status');
        unset($payload['image']);

        return $payload;
    }
}
