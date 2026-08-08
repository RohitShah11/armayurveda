<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('member_kycs')) {
            return;
        }

        Schema::create('member_kycs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('pan_number', 20)->nullable();
            $table->string('pan_image')->nullable();
            $table->string('aadhaar_number', 20)->nullable();
            $table->string('aadhaar_front')->nullable();
            $table->string('aadhaar_back')->nullable();
            $table->string('account_holder_name', 150)->nullable();
            $table->string('bank_name', 150)->nullable();
            $table->string('account_number', 50)->nullable();
            $table->string('ifsc_code', 20)->nullable();
            $table->string('branch_name', 150)->nullable();
            $table->string('passbook_image')->nullable();
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // This migration also supports databases where this legacy table already exists.
    }
};
