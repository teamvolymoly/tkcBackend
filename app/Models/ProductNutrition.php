<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductNutrition extends Model
{
    protected $table = 'product_nutritions';

    protected $fillable = [
        'product_id',
        'nutrient',
        'value',
        'unit',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
