<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('price_sheets', function (Blueprint $table) {
            $table->id();
            $table->string('pdf_url', 255)->nullable();
            $table->string('title', 255);
            $table->date('effective_date');
            $table->timestamp('uploaded_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('price_sheets');
    }
};
