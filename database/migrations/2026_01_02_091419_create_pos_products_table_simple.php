<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pos_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('pos_stores')->onDelete('cascade');
            $table->string('name');
            $table->string('category')->default('general');
            $table->decimal('selling_price', 10, 2);
            $table->decimal('buying_price', 10, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->string('unit')->default('bag');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pos_products');
    }
};