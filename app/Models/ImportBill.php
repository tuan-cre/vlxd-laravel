<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ImportBill extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'user_id',
        'import_date',
        'total_money',
        'note',
        'status',
        'warehouse_id',
    ];

    protected function casts(): array
    {
        return [
            'supplier_id' => 'integer',
            'user_id' => 'integer',
            'import_date' => 'date',
            'total_money' => 'decimal:0',
            'warehouse_id' => 'integer',
        ];
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(ImportBillDetail::class, 'import_id');
    }
}
