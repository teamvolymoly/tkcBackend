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
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->latest('published_at')
            ->latest('id')
            ->limit(3)
            ->get([
                'id',
                'title',
                'slug',
                'excerpt',
                'content',
                'featured_image_path',
                'published_at',
                'created_at',
                'updated_at',
            ]);

        return response()->json([
            'status' => true,
            'message' => 'Home blog posts fetched successfully',
            'data' => $posts,
        ]);
    }
}
