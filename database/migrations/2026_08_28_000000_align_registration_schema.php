<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'mobile')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('mobile')->nullable()->unique()->after('email');
            });
        }

        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
        });

        if (! Schema::hasTable('member_profiles')) {
            Schema::create('member_profiles', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
                $table->string('mobile')->nullable();
                $table->date('dob')->nullable();
                $table->string('gender')->nullable();
                $table->text('address')->nullable();
                $table->string('state')->nullable();
                $table->string('city')->nullable();
                $table->string('pin_code')->nullable();
                $table->string('nominee_name')->nullable();
                $table->string('nominee_relation')->nullable();
                $table->string('profile_photo')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        // Existing installations may have pre-dated this migration, so rollback is intentionally non-destructive.
    }
};
