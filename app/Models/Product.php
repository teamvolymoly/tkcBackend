<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'subcategory_id',
        'tag_line_1',
        'name',
        'slug',
        'tag_line_2',
        'description',
        'image_1',
        'image_2',
        'image_3',
        'image_4',
        'image_5',
        'ingredients',
        'faqs',
        'status',
    ];

    protected $casts = [
        'ingredients' => 'array',
        'faqs' => 'array',
        'status' => 'boolean',
    ];

    protected $appends = [
        'gallery',
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
        return $this->hasOne(ProductVariant::class)->where('is_default', true);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function getGalleryAttribute(): array
    {
        return collect(range(1, 5))
            ->map(fn (int $index) => $this->{'image_'.$index})
            ->filter()
            ->values()
            ->map(fn (string $path, int $index) => [
                'id' => $index + 1,
                'image_path' => $path,
                'image_url' => $this->resolveMediaUrl($path),
                'number' => $index + 1,
            ])
            ->all();
    }

    public function resolveMediaUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (preg_match('/^https?:\/\//i', $path)) {
            return $path;
        }

        return route('media.public', ['path' => ltrim($path, '/')]);
    }
}
