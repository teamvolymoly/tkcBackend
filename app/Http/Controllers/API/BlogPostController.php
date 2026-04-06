<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BlogPostController extends Controller
{
    public function index(Request $request)
    {
        $isAdmin = $request->user()?->hasRole('admin') ?? false;

        $posts = BlogPost::query()
            ->when(! $isAdmin, function ($query) {
                $query->where('status', true)
                    ->where(function ($inner) {
                        $inner->whereNull('published_at')
                            ->orWhere('published_at', '<=', now());
                    });
            })
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = $request->q;
                $query->where(function ($inner) use ($term) {
                    $inner->where('title', 'like', "%{$term}%")
                        ->orWhere('excerpt', 'like', "%{$term}%")
                        ->orWhere('content', 'like', "%{$term}%");
                });
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->boolean('status')))
            ->latest('published_at')
            ->latest('id')
            ->paginate($isAdmin ? 20 : 12)
            ->withQueryString();

        return response()->json([
            'status' => true,
            'message' => 'Blog posts fetched successfully',
            'data' => $posts,
        ]);
    }

    public function show(Request $request, BlogPost $blogPost)
    {
        $isAdmin = $request->user()?->hasRole('admin') ?? false;

        if (! $isAdmin && (! $blogPost->status || ($blogPost->published_at && $blogPost->published_at->isFuture()))) {
            abort(404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Blog post fetched successfully',
            'data' => $blogPost,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);

        $post = BlogPost::create([
            'title' => $validated['title'],
            'slug' => $this->uniqueSlug($validated['title']),
            'excerpt' => $validated['excerpt'] ?? null,
            'content' => $validated['content'],
            'featured_image_path' => $request->hasFile('featured_image') ? $request->file('featured_image')->store('blog', 'public') : null,
            'status' => $request->boolean('status', true),
            'published_at' => $validated['published_at'] ?? null,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Blog post created successfully',
            'data' => $post,
        ], 201);
    }

    public function update(Request $request, BlogPost $blogPost)
    {
        $validated = $this->validated($request, $blogPost);
        $imagePath = $blogPost->featured_image_path;

        if ($request->hasFile('featured_image')) {
            if ($imagePath && ! Str::startsWith($imagePath, ['http://', 'https://'])) {
                Storage::disk('public')->delete($imagePath);
            }

            $imagePath = $request->file('featured_image')->store('blog', 'public');
        }

        $blogPost->update([
            'title' => $validated['title'],
            'slug' => $this->uniqueSlug($validated['title'], $blogPost->id),
            'excerpt' => $validated['excerpt'] ?? null,
            'content' => $validated['content'],
            'featured_image_path' => $imagePath,
            'status' => $request->boolean('status'),
            'published_at' => $validated['published_at'] ?? null,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Blog post updated successfully',
            'data' => $blogPost->fresh(),
        ]);
    }

    public function destroy(BlogPost $blogPost)
    {
        if ($blogPost->featured_image_path && ! Str::startsWith($blogPost->featured_image_path, ['http://', 'https://'])) {
            Storage::disk('public')->delete($blogPost->featured_image_path);
        }

        $blogPost->delete();

        return response()->json([
            'status' => true,
            'message' => 'Blog post deleted successfully',
        ]);
    }

    private function validated(Request $request, ?BlogPost $blogPost = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'featured_image' => ['nullable', 'image', 'max:5120'],
            'status' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('blog_posts', 'slug')->ignore($blogPost?->id),
            ],
        ]);
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base !== '' ? $base : 'blog-post';
        $original = $slug;
        $counter = 1;

        while (BlogPost::query()
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->where('slug', $slug)
            ->exists()) {
            $slug = $original.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
