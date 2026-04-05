<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'variant_name',
        'size',
        'color',
        'sku',
        'price',
        'stock',
        'weight',
        'dimensions',
        'net_weight',
        'tags',
        'brewing_rituals',
        'is_default',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'weight' => 'decimal:2',
        'tags' => 'array',
        'brewing_rituals' => 'array',
        'is_default' => 'boolean',
        'status' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function inventory(): HasOne
    {
        return $this->hasOne(Inventory::class, 'variant_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductVariantImage::class, 'variant_id')
            ->orderByDesc('is_primary')
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(ProductVariantImage::class, 'variant_id')
            ->where('is_primary', true);
    }
}
