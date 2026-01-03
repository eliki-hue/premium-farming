<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pos_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('pos_stores')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('pos_users')->onDelete('cascade');
            $table->string('order_number')->unique();
            $table->string('customer_name')->nullable();
            $table->enum('payment_method', ['cash', 'mpesa', 'card'])->default('cash');
            $table->decimal('total_amount', 12, 2);
            $table->decimal('amount_paid', 12, 2);
            $table->enum('status', ['pending', 'completed', 'cancelled', 'hold'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pos_orders');
    }
};