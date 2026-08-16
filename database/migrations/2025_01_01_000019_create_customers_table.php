<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('role_id')->default(2);
            $table->string('fullname', 100);
            $table->string('email', 100)->unique();
            $table->string('phone_number', 20)->nullable();
            $table->string('address', 255)->nullable();
            $table->date('birthday')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('avatar', 255)->nullable();
            $table->enum('member_level', ['bronze', 'silver', 'gold', 'platinum'])->default('bronze');
            $table->integer('loyalty_points')->default(0);
            $table->decimal('total_spent', 15, 0)->default(0);
            $table->integer('total_orders')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->dateTime('last_order_date')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
