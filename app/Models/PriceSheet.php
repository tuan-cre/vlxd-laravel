<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceSheet extends Model
{
    use HasFactory;

    protected $table = 'price_sheets';

    protected $fillable = [
        'pdf_url',
        'title',
        'effective_date',
        'uploaded_at',
    ];

    protected function casts(): array
    {
        return [
            'effective_date' => 'date',
            'uploaded_at' => 'datetime',
        ];
    }
}
