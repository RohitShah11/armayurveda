<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('zenith_pool_nodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->unique()->constrained()->cascadeOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('zenith_pool_nodes')->nullOnDelete();
            $table->foreignId('package_purchase_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedTinyInteger('position')->default(1);
            $table->unsignedInteger('depth')->default(0);
            $table->timestamp('joined_at')->nullable();
            $table->timestamps();

            $table->unique(['parent_id', 'position']);
            $table->index(['depth', 'id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zenith_pool_nodes');
    }
};
