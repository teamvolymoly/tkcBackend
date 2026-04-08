<?php

namespace App\Models;

use App\Support\ProductSchema;
use App\Support\PublicMediaUrl;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductVariantImage extends Model
{
    protected $fillable = [
        'variant_id',
        'image_path',
        'image_url',
        'is_primary',
        'sort_order',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    protected $appends = [
        'image_url',
    ];

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(function ($value) {
            $source = $this->image_path ?: $value;

            if (! $source) {
                return null;
            }

            if (Str::startsWith($source, ['http://', 'https://'])) {
                return $source;
            }

            return PublicMediaUrl::make($source);
        });
    }

    protected function imagePath(): Attribute
    {
        return Attribute::get(function ($value) {
            if ($value) {
                return $value;
            }

            return ProductSchema::hasColumn('product_variant_images', 'image_url')
                ? $this->getRawOriginal('image_url')
                : null;
        });
    }
}
