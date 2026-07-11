<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'earning_wallet')) {
                $table->decimal('earning_wallet', 12, 2)->default(0)->after('main_wallet');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'earning_wallet')) {
                $table->dropColumn('earning_wallet');
            }
        });
    }
};
