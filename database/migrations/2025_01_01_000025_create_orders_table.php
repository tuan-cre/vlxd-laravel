<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->string('fullname', 100);
            $table->string('phone_number', 20);
            $table->string('address', 255);
            $table->text('note')->nullable();
            $table->dateTime('order_date');
            $table->integer('status')->default(1);
            $table->string('payment_method', 50)->default('COD');
            $table->tinyInteger('payment_status')->default(0);
            $table->decimal('shipping_fee', 15, 0)->default(0);
            $table->decimal('discount_amount', 15, 0)->default(0);
            $table->decimal('total_money', 15, 0);
            $table->tinyInteger('stock_applied')->default(0);
            $table->foreignId('coupon_id')->nullable()->constrained('coupons')->nullOnDelete();
            $table->integer('earned_points')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
