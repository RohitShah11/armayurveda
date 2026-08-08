<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('package_purchases') || Schema::hasIndex('package_purchases', ['user_id'], 'unique')) {
            return;
        }

        Schema::table('package_purchases', function (Blueprint $table) {
            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('package_purchases') || ! Schema::hasIndex('package_purchases', ['user_id'], 'unique')) {
            return;
        }

        Schema::table('package_purchases', function (Blueprint $table) {
            $table->dropUnique(['user_id']);
        });
    }
};
