<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('product_name');
            $table->decimal('unit_price', 12, 2);
            $table->unsignedInteger('quantity');
            $table->decimal('total_amount', 12, 2);
            $table->string('status')->default('Pending');
            $table->string('payment_status')->default('Paid');
            $table->text('admin_note')->nullable();
            $table->timestamp('ordered_at');
            $table->timestamps();
            $table->index(['status', 'ordered_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_orders');
    }
};
