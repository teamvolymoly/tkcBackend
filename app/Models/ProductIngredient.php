<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use App\Support\PublicMediaUrl;
use Illuminate\Support\Str;

class ProductIngredient extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'value',
        'image_path',
        'sort_order',
    ];

    protected $appends = [
        'image_url',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(function () {
            if (! $this->image_path) {
                return null;
            }

            if (Str::startsWith($this->image_path, ['http://', 'https://'])) {
                return $this->image_path;
            }

            return PublicMediaUrl::make($this->image_path);
        });
    }
}
