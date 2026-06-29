<?php

namespace App\Models;

use App\Support\PublicMediaUrl;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ReviewImage extends Model
{
    protected $fillable = [
        'review_id',
        'image_path',
        'sort_order',
    ];

    protected $appends = [
        'image_url',
    ];

    protected static function booted(): void
    {
        static::deleting(function (ReviewImage $image) {
            if ($image->image_path && ! Str::startsWith($image->image_path, ['http://', 'https://'])) {
                Storage::disk('public')->delete($image->image_path);
            }
        });
    }

    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        return PublicMediaUrl::make($this->image_path);
    }
}
