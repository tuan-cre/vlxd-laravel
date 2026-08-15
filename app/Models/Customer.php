<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'role_id',
        'fullname',
        'email',
        'phone_number',
        'address',
        'birthday',
        'gender',
        'avatar',
        'member_level',
        'loyalty_points',
        'total_spent',
        'total_orders',
        'status',
        'created_at',
        'updated_at',
        'last_order_date',
    ];

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'role_id' => 'integer',
            'birthday' => 'date',
            'loyalty_points' => 'integer',
            'total_spent' => 'decimal:0',
            'total_orders' => 'integer',
            'status' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'last_order_date' => 'datetime',
        ];
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(CustomerAddress::class);
    }

    public function coupons(): BelongsToMany
    {
        return $this->belongsToMany(Coupon::class, 'customer_coupons', 'customer_id', 'coupon_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
