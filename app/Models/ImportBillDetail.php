<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImportBillDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'import_id',
        'product_id',
        'quantity',
        'import_price',
        'total_money',
    ];

    protected function casts(): array
    {
        return [
            'import_id' => 'integer',
            'product_id' => 'integer',
            'quantity' => 'integer',
            'import_price' => 'decimal:0',
            'total_money' => 'decimal:0',
        ];
    }

    public function importBill(): BelongsTo
    {
        return $this->belongsTo(ImportBill::class, 'import_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
