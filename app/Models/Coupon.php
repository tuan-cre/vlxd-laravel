<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'min_order_value',
        'start_date',
        'end_date',
        'usage_limit',
        'status',
        'points_cost',
        'min_member_level',
        'requires_claim',
    ];

    protected function casts(): array
    {
        return [
            'discount_value' => 'decimal:0',
            'min_order_value' => 'decimal:0',
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'usage_limit' => 'integer',
            'status' => 'integer',
            'points_cost' => 'integer',
            'requires_claim' => 'boolean',
        ];
    }

    public function customers(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class, 'customer_coupons', 'coupon_id', 'customer_id');
    }

    public function orders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Order::class);
    }
}
