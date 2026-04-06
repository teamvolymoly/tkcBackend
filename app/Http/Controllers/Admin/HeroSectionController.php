<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HeroSectionController extends BaseAdminController
{
    public function index(Request $request): View
    {
        $filters = $request->only(['q', 'status', 'page']);

        return view('admin.hero-sections.index', [
            'heroSections' => $this->apiService->get('hero-sections', array_filter($filters, fn ($value) => $value !== null && $value !== ''))['data'] ?? [],
            'filters' => $filters,
        ]);
    }

    public function create(): View
    {
        return view('admin.hero-sections.create', [
            'heroSection' => null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $response = $this->apiService->postMultipart('hero-sections', $this->payload($request), [
            'product_image' => $request->file('product_image'),
        ]);

        if (! $response['ok']) {
            return $this->backWithApiError($response, 'Unable to create hero section.');
        }

        return redirect()->route('admin.hero-sections.edit', $response['data']['id'] ?? null)->with('success', $response['message'] ?: 'Hero section created successfully.');
    }

    public function show(int $heroSection): View
    {
        $response = $this->apiService->get("hero-sections/{$heroSection}");
        abort_unless($response['ok'], 404);

        return view('admin.hero-sections.show', [
            'heroSection' => $response['data'],
        ]);
    }

    public function edit(int $heroSection): View
    {
        $response = $this->apiService->get("hero-sections/{$heroSection}");
        abort_unless($response['ok'], 404);

        return view('admin.hero-sections.edit', [
            'heroSection' => $response['data'],
        ]);
    }

    public function update(Request $request, int $heroSection): RedirectResponse
    {
        $response = $this->apiService->putMultipart("hero-sections/{$heroSection}", $this->payload($request), [
            'product_image' => $request->file('product_image'),
        ]);

        if (! $response['ok']) {
            return $this->backWithApiError($response, 'Unable to update hero section.');
        }

        return redirect()->route('admin.hero-sections.edit', $heroSection)->with('success', $response['message'] ?: 'Hero section updated successfully.');
    }

    public function destroy(int $heroSection): RedirectResponse
    {
        $response = $this->apiService->delete("hero-sections/{$heroSection}");

        if (! $response['ok']) {
            return back()->with('error', $response['message'] ?: 'Unable to delete hero section.');
        }

        return redirect()->route('admin.hero-sections.index')->with('success', $response['message'] ?: 'Hero section deleted successfully.');
    }

    private function payload(Request $request): array
    {
        return $request->validate([
            'product_image' => ['nullable', 'file', 'image', 'max:5120'],
            'product_name' => ['required', 'string', 'max:255'],
            'product_slug' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
    }
}
