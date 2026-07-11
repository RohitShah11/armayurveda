<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('zenith_pool_level_incomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zenith_pool_node_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('level');
            $table->unsignedInteger('slots_required');
            $table->decimal('amount', 12, 2);
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->unique(['zenith_pool_node_id', 'level']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zenith_pool_level_incomes');
    }
};
