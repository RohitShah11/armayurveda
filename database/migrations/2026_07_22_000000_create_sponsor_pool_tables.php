<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('sponsor_pool_nodes')) {
            Schema::create('sponsor_pool_nodes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
                $table->foreignId('purchaser_id')->nullable()->constrained('users')->cascadeOnDelete();
                $table->foreignId('admin_id')->nullable()->constrained()->cascadeOnDelete();
                $table->foreignId('parent_id')->nullable()->constrained('sponsor_pool_nodes')->nullOnDelete();
                $table->foreignId('package_purchase_id')->nullable()->unique()->constrained()->nullOnDelete();
                $table->unsignedTinyInteger('position')->default(1);
                $table->unsignedInteger('depth')->default(0);
                $table->timestamp('joined_at')->nullable();
                $table->timestamps();

                $table->unique(['parent_id', 'position']);
                $table->index(['depth', 'id']);
            });
        }

        if (! Schema::hasTable('sponsor_pool_level_incomes')) {
            Schema::create('sponsor_pool_level_incomes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('sponsor_pool_node_id')->constrained()->cascadeOnDelete();
                $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
                $table->foreignId('admin_id')->nullable()->constrained()->cascadeOnDelete();
                $table->unsignedTinyInteger('level');
                $table->unsignedInteger('slots_required');
                $table->decimal('amount', 12, 2);
                $table->timestamp('paid_at')->nullable();
                $table->timestamps();

                $table->unique(['sponsor_pool_node_id', 'level']);
            });
        }
    }

    public function down(): void
    {
        // These tables may predate Laravel's migration history on existing sites.
        // Preserve them during rollback to avoid deleting live sponsor-pool data.
    }
};
