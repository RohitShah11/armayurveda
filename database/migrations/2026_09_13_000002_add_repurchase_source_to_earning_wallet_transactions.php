<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('earning_wallet_transactions', function (Blueprint $table) {
            $table->foreignId('product_order_id')->nullable()->after('package_purchase_id')->constrained('product_orders')->nullOnDelete();
            $table->unique(['product_order_id', 'level'], 'earning_wallet_repurchase_order_level_unique');
        });
    }

    public function down(): void
    {
        Schema::table('earning_wallet_transactions', function (Blueprint $table) {
            $table->dropUnique('earning_wallet_repurchase_order_level_unique');
            $table->dropConstrainedForeignId('product_order_id');
        });
    }
};
