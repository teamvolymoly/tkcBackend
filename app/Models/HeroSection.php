<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
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

            $path = 'storage/'.ltrim($this->product_image_path, '/');

            if (app()->bound('request')) {
                return rtrim(request()->root(), '/').'/'.$path;
            }

            return rtrim((string) config('app.url'), '/').'/'.$path;
        });
    }
}
