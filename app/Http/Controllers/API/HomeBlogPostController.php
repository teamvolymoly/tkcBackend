<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\JsonResponse;

class HomeBlogPostController extends Controller
{
    public function index(): JsonResponse
    {
        $posts = BlogPost::query()
            ->where('status', true)
            ->latest('published_at')
            ->latest('id')
            ->limit(3)
            ->get([
                'id',
                'title',
                'slug',
                'excerpt',
                'featured_image_path',
                'published_at',
            ])
            ->map(fn (BlogPost $post) => [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'excerpt' => $post->excerpt,
                'featured_image_path' => $post->featured_image_url,
                'published_at' => $post->published_at,
            ])
            ->values();

        return response()->json([
            'status' => true,
            'message' => 'Home blog posts fetched successfully',
            'data' => $posts,
        ]);
    }
}
