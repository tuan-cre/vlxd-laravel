<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('slug', 255);
            $table->string('thumbnail', 255)->nullable();
            $table->text('summary')->nullable();
            $table->longText('content')->nullable();
            $table->string('category', 100)->nullable();
            $table->enum('status', ['draft', 'published'])->default('published');
            $table->integer('views')->default(0);
            $table->foreignId('author_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
