<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('repurchase_commission_levels', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('level')->unique();
            $table->decimal('commission_percent', 5, 2);
            $table->timestamps();
        });

        $now = now();
        DB::table('repurchase_commission_levels')->insert(collect([
            1 => 5, 2 => 2, 3 => 1,
            4 => 0.4, 5 => 0.4, 6 => 0.4,
            7 => 0.2, 8 => 0.2, 9 => 0.2, 10 => 0.2,
        ])->map(fn ($percent, $level) => [
            'level' => $level,
            'commission_percent' => $percent,
            'created_at' => $now,
            'updated_at' => $now,
        ])->values()->all());
    }

    public function down(): void
    {
        Schema::dropIfExists('repurchase_commission_levels');
    }
};
