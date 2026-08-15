<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'tax_code',
    ];

    protected function casts(): array
    {
        return [];
    }

    public function importBills(): HasMany
    {
        return $this->hasMany(ImportBill::class);
    }
}
