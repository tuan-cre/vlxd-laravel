<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'customer_id',
        'fullname',
        'phone_number',
        'address',
        'note',
        'order_date',
        'status',
        'payment_method',
        'payment_status',
        'shipping_fee',
        'discount_amount',
        'total_money',
        'stock_applied',
        'coupon_id',
        'earned_points',
    ];

    protected function casts(): array
    {
        return [
            'customer_id' => 'integer',
            'order_date' => 'datetime',
            'status' => 'integer',
            'payment_status' => 'boolean',
            'shipping_fee' => 'decimal:0',
            'discount_amount' => 'decimal:0',
            'total_money' => 'decimal:0',
            'stock_applied' => 'boolean',
            'coupon_id' => 'integer',
            'earned_points' => 'integer',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function orderInventories(): HasMany
    {
        return $this->hasMany(OrderInventory::class);
    }
}
