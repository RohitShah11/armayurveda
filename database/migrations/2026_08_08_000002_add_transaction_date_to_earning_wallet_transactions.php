<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('earning_wallet_transactions') || Schema::hasColumn('earning_wallet_transactions', 'transaction_date')) {
            return;
        }

        Schema::table('earning_wallet_transactions', function (Blueprint $table) {
            $table->timestamp('transaction_date')->nullable()->after('reference_no');
        });

        DB::table('earning_wallet_transactions')
            ->whereNull('transaction_date')
            ->update(['transaction_date' => DB::raw('created_at')]);
    }

    public function down(): void
    {
        if (! Schema::hasTable('earning_wallet_transactions') || ! Schema::hasColumn('earning_wallet_transactions', 'transaction_date')) {
            return;
        }

        Schema::table('earning_wallet_transactions', function (Blueprint $table) {
            $table->dropColumn('transaction_date');
        });
    }
};
