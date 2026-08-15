<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'price',
        'sale_price',
        'thumbnail',
        'description',
        'content',
        'unit',
        'stock',
        'views',
        'is_featured',
        'status',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'category_id' => 'integer',
            'brand_id' => 'integer',
            'price' => 'decimal:0',
            'sale_price' => 'decimal:0',
            'stock' => 'integer',
            'views' => 'integer',
            'is_featured' => 'boolean',
            'status' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class);
    }

    public function importBillDetails(): HasMany
    {
        return $this->hasMany(ImportBillDetail::class);
    }

    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function orderInventories(): HasMany
    {
        return $this->hasMany(OrderInventory::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
