<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_rank_rewards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('earning_wallet_transaction_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedTinyInteger('rank');
            $table->string('rank_name');
            $table->decimal('required_business', 14, 2);
            $table->decimal('qualified_business', 14, 2);
            $table->decimal('reward_amount', 12, 2);
            $table->string('additional_reward')->nullable();
            $table->string('status')->default('Paid');
            $table->timestamp('qualified_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'rank']);
            $table->index(['rank', 'qualified_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_rank_rewards');
    }
};
