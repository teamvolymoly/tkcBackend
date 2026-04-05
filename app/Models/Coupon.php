<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'min_order_amount',
        'max_discount',
        'expiry_date',
        'usage_limit',
        'per_user_limit',
        'required_completed_orders',
        'is_active',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'required_completed_orders' => 'integer',
        'is_active' => 'boolean',
        'expiry_date' => 'date',
    ];

    public function usages()
    {
        return $this->hasMany(CouponUsage::class);
    }
}
