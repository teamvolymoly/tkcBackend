<?php

namespace App\Models;

use App\Support\ProductSchema;
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
        'compare_price',
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
        'compare_price' => 'decimal:2',
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
        $relation = $this->hasMany(ProductVariantImage::class, 'variant_id');

        if (ProductSchema::hasColumn('product_variant_images', 'is_primary')) {
            $relation->orderByDesc('is_primary');
        }

        if (ProductSchema::hasColumn('product_variant_images', 'sort_order')) {
            $relation->orderBy('sort_order');
        }

        return $relation->orderBy('id');
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(ProductVariantImage::class, 'variant_id')
            ->when(
                ProductSchema::hasColumn('product_variant_images', 'is_primary'),
                fn ($query) => $query->where('is_primary', true),
                fn ($query) => $query->latest('id')
            );
    }
}
