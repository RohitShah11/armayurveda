<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EarningWalletTransaction extends Model
{
    protected $table = 'earning_wallet_transactions';

    protected $guarded = [];

    protected $casts = [
        'amount' => 'decimal:2',
        'opening_balance' => 'decimal:2',
        'closing_balance' => 'decimal:2',
        'level' => 'integer',
        'transaction_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sourceUser()
    {
        return $this->belongsTo(User::class, 'source_user_id');
    }

    public function packagePurchase()
    {
        return $this->belongsTo(PackagePurchase::class);
    }

    public function commissionLevel(): ?int
    {
        if ($this->level) {
            return (int) $this->level;
        }

        return preg_match('/^Level\s+(\d+)\s+commission\s+for\s+/i', (string) $this->description, $matches)
            ? (int) $matches[1]
            : null;
    }

    public function commissionPackageName(): string
    {
        if ($this->packagePurchase?->package_name) {
            return $this->packagePurchase->package_name;
        }

        return preg_match('/^Level\s+\d+\s+commission\s+for\s+(.+)$/i', (string) $this->description, $matches)
            ? trim($matches[1])
            : '-';
    }
}
