<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('brand_id')->constrained('brands');
            $table->string('name', 255);
            $table->string('slug', 255);
            $table->decimal('price', 15, 0);
            $table->decimal('sale_price', 15, 0)->default(0);
            $table->string('thumbnail', 255)->nullable();
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->string('unit', 50)->nullable();
            $table->integer('stock')->default(0);
            $table->integer('views')->default(0);
            $table->tinyInteger('is_featured')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
