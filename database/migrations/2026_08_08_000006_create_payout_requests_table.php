<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('payout_requests')) {
            return;
        }

        Schema::create('payout_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_no')->nullable()->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 15, 2);
            $table->decimal('charge', 15, 2)->default(0);
            $table->decimal('net_amount', 15, 2);
            $table->string('mode', 30);
            $table->string('upi_id', 100)->nullable();
            $table->string('account_holder_name', 150)->nullable();
            $table->string('bank_name', 150)->nullable();
            $table->string('account_number', 50)->nullable();
            $table->string('ifsc_code', 20)->nullable();
            $table->text('member_remark')->nullable();
            $table->string('status', 20)->default('Pending')->index();
            $table->string('payment_transaction_id', 100)->nullable()->index();
            $table->text('admin_remark')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamp('processed_at')->nullable();
            $table->foreignId('wallet_transaction_id')->nullable()->constrained('earning_wallet_transactions')->nullOnDelete();
            $table->foreignId('refund_transaction_id')->nullable()->constrained('earning_wallet_transactions')->nullOnDelete();
            $table->timestamp('refunded_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payout_requests');
    }
};
