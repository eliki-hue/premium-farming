<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_location')->nullable(); // e.g., Kiambu, Nairobi
            
            // Review content
            $table->text('review');
            $table->tinyInteger('rating')->unsigned(); // 1-5 stars
            $table->string('farm_type')->nullable(); // e.g., Dairy, Poultry, Pig
            
            // Product/service reviewed
            $table->string('product_name')->nullable();
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
            
            // Status and moderation
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('has_photo')->default(false);
            $table->string('photo_path')->nullable();
            
            // Timestamps
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for performance
            $table->index(['is_approved', 'created_at']);
            $table->index('rating');
            $table->index('farm_type');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};