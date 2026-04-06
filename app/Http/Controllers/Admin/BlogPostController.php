<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogPostController extends BaseAdminController
{
    public function index(Request $request): View
    {
        $filters = $request->only(['q', 'status', 'page']);

        return view('admin.blogs.index', [
            'posts' => $this->apiService->get('blog-posts', array_filter($filters, fn ($value) => $value !== null && $value !== ''))['data'] ?? [],
            'filters' => $filters,
        ]);
    }

    public function create(): View
    {
        return view('admin.blogs.create', [
            'post' => null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $response = $this->apiService->postMultipart('blog-posts', $this->payload($request), [
            'featured_image' => $request->file('featured_image'),
        ]);

        if (! $response['ok']) {
            return $this->backWithApiError($response, 'Unable to create blog post.');
        }

        return redirect()->route('admin.blogs.edit', $response['data']['id'] ?? null)->with('success', $response['message'] ?: 'Blog post created successfully.');
    }

    public function show(int $blog): View
    {
        $response = $this->apiService->get("blog-posts/{$blog}");
        abort_unless($response['ok'], 404);

        return view('admin.blogs.show', [
            'post' => $response['data'],
        ]);
    }

    public function edit(int $blog): View
    {
        $response = $this->apiService->get("blog-posts/{$blog}");
        abort_unless($response['ok'], 404);

        return view('admin.blogs.edit', [
            'post' => $response['data'],
        ]);
    }

    public function update(Request $request, int $blog): RedirectResponse
    {
        $response = $this->apiService->putMultipart("blog-posts/{$blog}", $this->payload($request), [
            'featured_image' => $request->file('featured_image'),
        ]);

        if (! $response['ok']) {
            return $this->backWithApiError($response, 'Unable to update blog post.');
        }

        return redirect()->route('admin.blogs.edit', $blog)->with('success', $response['message'] ?: 'Blog post updated successfully.');
    }

    public function destroy(int $blog): RedirectResponse
    {
        $response = $this->apiService->delete("blog-posts/{$blog}");

        if (! $response['ok']) {
            return back()->with('error', $response['message'] ?: 'Unable to delete blog post.');
        }

        return redirect()->route('admin.blogs.index')->with('success', $response['message'] ?: 'Blog post deleted successfully.');
    }

    private function payload(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'featured_image' => ['nullable', 'file', 'image', 'max:5120'],
            'status' => ['nullable'],
            'published_at' => ['nullable', 'date'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
        ]);
    }
}
