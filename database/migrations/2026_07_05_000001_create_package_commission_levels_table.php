<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('package_commission_levels', function (Blueprint $table) {
            $table->id();
            $table->string('package_category');
            $table->unsignedInteger('level');
            $table->decimal('commission_amount', 12, 2);
            $table->timestamps();

            $table->unique(['package_category', 'level']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_commission_levels');
    }
};
