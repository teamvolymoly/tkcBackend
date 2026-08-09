<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeBlogPostApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_blogs_returns_only_the_latest_three_active_blog_cards_without_pagination(): void
    {
        foreach (range(1, 4) as $index) {
            BlogPost::create([
                'title' => "Active Blog {$index}",
                'slug' => "active-blog-{$index}",
                'excerpt' => "Excerpt {$index}",
                'content' => "Content {$index}",
                'featured_image_path' => "blog/image-{$index}.webp",
                'status' => true,
                'published_at' => now()->subDays(4 - $index),
            ]);
        }

        BlogPost::create([
            'title' => 'Inactive Blog',
            'slug' => 'inactive-blog',
            'excerpt' => 'Inactive excerpt',
            'content' => 'Inactive content',
            'status' => false,
            'published_at' => now()->addDay(),
        ]);

        $response = $this->getJson('/api/home/blogs');

        $response
            ->assertOk()
            ->assertJsonPath('status', true)
            ->assertJsonCount(3, 'data')
            ->assertJsonPath('data.0.slug', 'active-blog-4')
            ->assertJsonMissingPath('data.0.content')
            ->assertJsonMissingPath('data.0.created_at')
            ->assertJsonMissingPath('data.0.updated_at')
            ->assertJsonMissingPath('data.current_page')
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [[
                    'id',
                    'title',
                    'slug',
                    'excerpt',
                    'featured_image_path',
                    'published_at',
                ]],
            ]);
    }
}
