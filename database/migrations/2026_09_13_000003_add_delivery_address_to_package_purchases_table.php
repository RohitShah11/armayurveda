<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('package_purchases', function (Blueprint $table) {
            $table->text('delivery_address')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('package_purchases', function (Blueprint $table) {
            $table->dropColumn('delivery_address');
        });
    }
};
