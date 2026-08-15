<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'receiver_name',
        'phone_number',
        'province',
        'district',
        'ward',
        'address_detail',
        'is_default',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'customer_id' => 'integer',
            'is_default' => 'boolean',
            'created_at' => 'datetime',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
