<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('import_bill_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('import_id')->constrained('import_bills')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products');
            $table->integer('quantity');
            $table->decimal('import_price', 15, 0);
            $table->decimal('total_money', 15, 0)->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('import_bill_details');
    }
};
