<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guest_product_orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('public_token')->unique();
            $table->string('order_number')->unique();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('product_name');
            $table->decimal('unit_price', 12, 2);
            $table->unsignedInteger('quantity');
            $table->decimal('total_amount', 12, 2);
            $table->string('customer_name', 150);
            $table->string('mobile', 20);
            $table->string('email')->nullable();
            $table->text('shipping_address');
            $table->string('city', 150);
            $table->string('state', 150);
            $table->string('pincode', 10);
            $table->string('payment_method', 30);
            $table->string('payment_status', 30)->default('Pending');
            $table->string('utr_number', 100)->nullable();
            $table->string('payment_proof')->nullable();
            $table->string('status', 30)->default('Pending');
            $table->text('admin_note')->nullable();
            $table->timestamp('ordered_at');
            $table->timestamps();
            $table->index(['status', 'ordered_at']);
            $table->index(['payment_method', 'payment_status']);
            $table->index('mobile');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guest_product_orders');
    }
};
