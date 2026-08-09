<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('earning_wallet_transactions')) {
            return;
        }

        if (! Schema::hasColumn('earning_wallet_transactions', 'source_user_id')) {
            Schema::table('earning_wallet_transactions', function (Blueprint $table) {
                $table->foreignId('source_user_id')
                    ->nullable()
                    ->after('user_id')
                    ->constrained('users')
                    ->nullOnDelete();
            });
        }

        if (! Schema::hasColumn('earning_wallet_transactions', 'package_purchase_id')) {
            Schema::table('earning_wallet_transactions', function (Blueprint $table) {
                $table->foreignId('package_purchase_id')
                    ->nullable()
                    ->after('source_user_id')
                    ->constrained('package_purchases')
                    ->nullOnDelete();
            });
        }

        if (! Schema::hasColumn('earning_wallet_transactions', 'level')) {
            Schema::table('earning_wallet_transactions', function (Blueprint $table) {
                $table->unsignedInteger('level')->nullable()->after('package_purchase_id')->index();
            });
        }

        $this->backfillLegacyLevelCommissions();
    }

    public function down(): void
    {
        if (! Schema::hasTable('earning_wallet_transactions')) {
            return;
        }

        if (Schema::hasColumn('earning_wallet_transactions', 'package_purchase_id')) {
            Schema::table('earning_wallet_transactions', function (Blueprint $table) {
                $table->dropConstrainedForeignId('package_purchase_id');
            });
        }

        if (Schema::hasColumn('earning_wallet_transactions', 'source_user_id')) {
            Schema::table('earning_wallet_transactions', function (Blueprint $table) {
                $table->dropConstrainedForeignId('source_user_id');
            });
        }

        if (Schema::hasColumn('earning_wallet_transactions', 'level')) {
            Schema::table('earning_wallet_transactions', function (Blueprint $table) {
                $table->dropColumn('level');
            });
        }
    }

    private function backfillLegacyLevelCommissions(): void
    {
        DB::table('earning_wallet_transactions')
            ->whereNull('level')
            ->whereRaw('LOWER(description) LIKE ?', ['level % commission for %'])
            ->orderBy('id')
            ->chunkById(100, function ($transactions) {
                foreach ($transactions as $transaction) {
                    if (! preg_match('/^Level\s+(\d+)\s+commission\s+for\s+/i', (string) $transaction->description, $descriptionMatch)) {
                        continue;
                    }

                    $level = (int) $descriptionMatch[1];
                    $details = ['level' => $level];

                    if (preg_match('/^LEVEL-\d+-(\d+)-(\d+)$/', (string) $transaction->reference_no, $referenceMatch)) {
                        $packageId = (int) $referenceMatch[1];
                        $timestamp = Carbon::createFromTimestamp((int) $referenceMatch[2], 'UTC');
                        $purchases = DB::table('package_purchases')
                            ->where('package_id', $packageId)
                            ->whereBetween('purchase_date', [
                                $timestamp->copy()->subSeconds(10)->toDateTimeString(),
                                $timestamp->copy()->addSeconds(10)->toDateTimeString(),
                            ])
                            ->get(['id', 'user_id']);

                        foreach ($purchases as $purchase) {
                            if ($this->recipientMatchesLevel($purchase->user_id, $transaction->user_id, $level)) {
                                $details['source_user_id'] = $purchase->user_id;
                                $details['package_purchase_id'] = $purchase->id;
                                break;
                            }
                        }
                    }

                    DB::table('earning_wallet_transactions')
                        ->where('id', $transaction->id)
                        ->update($details);
                }
            });
    }

    private function recipientMatchesLevel(int $buyerId, int $recipientId, int $targetLevel): bool
    {
        $sponsorId = DB::table('users')->where('id', $buyerId)->value('sponsor_id');

        for ($level = 1; $level <= $targetLevel && $sponsorId; $level++) {
            $sponsor = DB::table('users')
                ->where('member_id', $sponsorId)
                ->first(['id', 'sponsor_id']);

            if (! $sponsor) {
                return false;
            }

            if ($level === $targetLevel) {
                return (int) $sponsor->id === $recipientId;
            }

            $sponsorId = $sponsor->sponsor_id;
        }

        return false;
    }
};
