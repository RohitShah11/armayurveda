<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->dropAdminId('direct_tree_nodes');
        $this->dropAdminId('zenith_pool_nodes');
        $this->dropAdminId('zenith_pool_level_incomes');
        $this->dropAdminId('sponsor_pool_nodes');
        $this->dropAdminId('sponsor_pool_level_incomes');
    }

    public function down(): void
    {
        $this->addAdminId('direct_tree_nodes');
        $this->addAdminId('zenith_pool_nodes');
        $this->addAdminId('zenith_pool_level_incomes');
        $this->addAdminId('sponsor_pool_nodes');
        $this->addAdminId('sponsor_pool_level_incomes');
    }

    private function dropAdminId(string $tableName): void
    {
        if (! Schema::hasTable($tableName) || ! Schema::hasColumn($tableName, 'admin_id')) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table) {
            $table->dropConstrainedForeignId('admin_id');
        });
    }

    private function addAdminId(string $tableName): void
    {
        if (! Schema::hasTable($tableName) || Schema::hasColumn($tableName, 'admin_id')) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table) {
            $table->foreignId('admin_id')->nullable()->constrained()->cascadeOnDelete();
        });
    }
};
