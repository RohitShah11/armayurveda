<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'status')) {
                $table->string('status')->default('Active');
            }

            if (! Schema::hasColumn('users', 'main_wallet')) {
                $table->decimal('main_wallet', 12, 2)->default(0)->after('remember_token');
            }

            if (! Schema::hasColumn('users', 'member_id')) {
                $table->string('member_id')->nullable()->after('main_wallet');
            }

            if (! Schema::hasColumn('users', 'sponsor_id')) {
                $table->string('sponsor_id')->nullable()->after('member_id');
            }
        });
    }

    public function down(): void
    {
        //
    }
};
