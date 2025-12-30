<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up()
{
    Schema::create('pos_products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('description')->nullable();
        $table->decimal('buying_price', 8, 2)->default(0);  // Cost price from supplier
        $table->decimal('selling_price', 8, 2);             // Retail price to customers
        $table->string('unit')->default('kg');
        $table->integer('stock')->default(0);
        $table->integer('low_stock_warning')->default(5);
        $table->string('category')->default('produce');
        $table->boolean('track_stock')->default(true);
        $table->timestamps();
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos_products');
    }
};
