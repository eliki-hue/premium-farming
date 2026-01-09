<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('delivery_zones', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('base_fee', 10, 2)->default(0);
            $table->integer('free_distance_km')->default(5);
            $table->decimal('per_km_fee', 10, 2)->default(0);
            $table->json('weight_tiers')->nullable(); // JSON for weight pricing
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('delivery_pricing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('delivery_zone_id')->constrained()->onDelete('cascade');
            $table->decimal('min_weight_kg', 10, 2);
            $table->decimal('max_weight_kg', 10, 2);
            $table->decimal('fee', 10, 2);
            $table->timestamps();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('delivery_zone_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('delivery_distance_km', 8, 2)->nullable();
            $table->decimal('total_weight_kg', 10, 2)->default(0);
            $table->decimal('delivery_base_fee', 10, 2)->default(0);
            $table->decimal('delivery_distance_fee', 10, 2)->default(0);
            $table->decimal('delivery_weight_fee', 10, 2)->default(0);
            $table->decimal('total_delivery_fee', 10, 2)->default(0);
            $table->string('delivery_address')->nullable();
            $table->string('delivery_notes')->nullable();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['delivery_zone_id']);
            $table->dropColumn([
                'delivery_zone_id',
                'delivery_distance_km',
                'total_weight_kg',
                'delivery_base_fee',
                'delivery_distance_fee',
                'delivery_weight_fee',
                'total_delivery_fee',
                'delivery_address',
                'delivery_notes'
            ]);
        });
        Schema::dropIfExists('delivery_pricing');
        Schema::dropIfExists('delivery_zones');
    }
};