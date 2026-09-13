<?php

namespace App\Services;

use App\Models\EarningWalletTransaction;
use App\Models\ProductOrder;
use App\Models\RepurchaseCommissionLevel;
use App\Models\User;

class RepurchaseCommissionService
{
    public function distribute(ProductOrder $order): void
    {
        if ($order->status !== 'Delivered') {
            return;
        }

        $levels = RepurchaseCommissionLevel::query()
            ->orderBy('level')
            ->get()
            ->keyBy('level');

        $buyer = User::whereKey($order->user_id)->lockForUpdate()->first();
        $currentSponsorId = $buyer?->sponsor_id;

        foreach ($levels as $level => $configuration) {
            if (! $currentSponsorId) {
                break;
            }

            $sponsor = User::where('member_id', $currentSponsorId)->lockForUpdate()->first();

            if (! $sponsor) {
                break;
            }

            $alreadyDistributed = EarningWalletTransaction::where('product_order_id', $order->id)
                ->where('level', $level)
                ->exists();

            if (! $alreadyDistributed) {
                $amount = round((float) $order->total_amount * (float) $configuration->commission_percent / 100, 2);

                if ($amount > 0) {
                    $opening = round((float) ($sponsor->earning_wallet ?? 0), 2);
                    $closing = $opening + $amount;
                    $sponsor->update(['earning_wallet' => $closing]);

                    EarningWalletTransaction::create([
                        'user_id' => $sponsor->id,
                        'source_user_id' => $buyer->id,
                        'product_order_id' => $order->id,
                        'level' => $level,
                        'type' => 'Credit',
                        'amount' => $amount,
                        'opening_balance' => $opening,
                        'closing_balance' => $closing,
                        'description' => 'Level '.$level.' repurchase commission for '.$order->product_name,
                        'reference_no' => 'REPURCHASE-'.$order->id.'-LEVEL-'.$level,
                        'transaction_date' => now(),
                    ]);
                }
            }

            $currentSponsorId = $sponsor->sponsor_id;
        }
    }
}
