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
        Schema::create('temp_orders', function (Blueprint $table) {
            $table->id();
            $table->string('session_id');
            $table->string('order_ref')->unique();
            $table->unsignedBigInteger('django_user_id')->nullable();
            $table->json('cart_items');
            $table->decimal('subtotal', 10, 2);
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_email')->nullable();
            $table->text('delivery_address')->nullable();
            $table->string('county')->nullable();
            $table->string('town')->nullable();
            $table->string('delivery_type')->nullable();
            $table->decimal('delivery_charge', 10, 2)->nullable();
            $table->string('whatsapp_message')->nullable();
            $table->string('whatsapp_message_id')->nullable();
            $table->string('status')->default('whatsapp_initiated');
            $table->timestamp('whatsapp_sent_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            
            $table->index('session_id');
            $table->index('order_ref');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('temp_orders');
    }
};
