<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'sku',
        'price',
        'discount_price',
        'weight',
        'brewing_rituals',
        'is_default',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'brewing_rituals' => 'array',
        'is_default' => 'boolean',
        'status' => 'boolean',
    ];

    protected $appends = [
        'primary_image',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getPrimaryImageAttribute(): ?array
    {
        $path = $this->product?->image_1;

        if (! $path && $this->product) {
            $path = collect($this->product->gallery)->first()['image_path'] ?? null;
        }

        if (! $path) {
            return null;
        }

        return [
            'image_path' => $path,
            'image_url' => $this->product?->resolveMediaUrl($path),
        ];
    }
}
