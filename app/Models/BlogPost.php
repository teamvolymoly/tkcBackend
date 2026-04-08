<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use App\Support\PublicMediaUrl;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image_path',
        'status',
        'published_at',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'status' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected $appends = [
        'featured_image_url',
    ];

    protected function featuredImageUrl(): Attribute
    {
        return Attribute::get(function () {
            if (! $this->featured_image_path) {
                return null;
            }

            if (Str::startsWith($this->featured_image_path, ['http://', 'https://'])) {
                return $this->featured_image_path;
            }

            return PublicMediaUrl::make($this->featured_image_path);
        });
    }
}
