<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->enum('discount_type', ['percent', 'fixed']);
            $table->decimal('discount_value', 15, 0);
            $table->decimal('min_order_value', 15, 0)->default(0);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('usage_limit')->default(100);
            $table->tinyInteger('status')->default(1);
            $table->integer('points_cost')->default(0);
            $table->enum('min_member_level', ['bronze', 'silver', 'gold', 'platinum'])->default('bronze');
            $table->tinyInteger('requires_claim')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
