<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HeroSection extends Model
{
    protected $fillable = [
        'product_image_path',
        'product_name',
        'product_slug',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'status' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected $appends = [
        'product_image_url',
    ];

    protected function productImageUrl(): Attribute
    {
        return Attribute::get(function () {
            if (! $this->product_image_path) {
                return null;
            }

            if (Str::startsWith($this->product_image_path, ['http://', 'https://'])) {
                return $this->product_image_path;
            }

            return Storage::disk('public')->url($this->product_image_path);
        });
    }
}
