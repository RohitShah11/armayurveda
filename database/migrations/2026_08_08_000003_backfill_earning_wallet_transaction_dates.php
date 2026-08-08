<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('earning_wallet_transactions') || ! Schema::hasColumn('earning_wallet_transactions', 'transaction_date')) {
            return;
        }

        DB::table('earning_wallet_transactions')
            ->whereNull('transaction_date')
            ->update(['transaction_date' => DB::raw('created_at')]);
    }

    public function down(): void
    {
        // Historical transaction dates are intentionally preserved.
    }
};
