<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->string('seller')->nullable();
            $table->string('brand')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('hsn_code')->nullable();
            $table->decimal('repurchase_distribution', 10, 2)->default(0);
            $table->decimal('mrp', 10, 2);
            $table->decimal('retail_price', 10, 2);
            $table->unsignedInteger('refund_days')->default(0);
            $table->string('image')->nullable();
            $table->json('gallery_images')->nullable();
            $table->string('product_section')->nullable();
            $table->boolean('has_variants')->default(false);
            $table->text('short_description')->nullable();
            $table->text('refund_description')->nullable();
            $table->longText('full_description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
