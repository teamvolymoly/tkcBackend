<?php

namespace App\Models;

use App\Support\ProductSchema;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'subcategory_id',
        'name',
        'slug',
        'short_description',
        'allergic_information',
        'tea_type',
        'disclaimer',
        'description',
        'ingredients',
        'features',
        'status',
    ];

    protected $casts = [
        'features' => 'array',
        'status' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'subcategory_id');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function defaultVariant(): HasOne
    {
        return $this->hasOne(ProductVariant::class)
            ->when(
                ProductSchema::hasColumn('product_variants', 'is_default'),
                fn ($query) => $query->where('is_default', true),
                fn ($query) => $query->latest('id')
            );
    }

    public function ingredientsList(): HasMany
    {
        return $this->hasMany(ProductIngredient::class);
    }

    public function nutrition(): HasMany
    {
        return $this->hasMany(ProductNutrition::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
