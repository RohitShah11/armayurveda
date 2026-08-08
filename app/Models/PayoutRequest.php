<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayoutRequest extends Model
{
    public const MINIMUM_AMOUNT = 500;

    protected $guarded = [];

    protected $casts = [
        'amount' => 'decimal:2',
        'charge' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'processed_at' => 'datetime',
        'refunded_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function processedBy()
    {
        return $this->belongsTo(Admin::class, 'processed_by');
    }

    public function walletTransaction()
    {
        return $this->belongsTo(EarningWalletTransaction::class, 'wallet_transaction_id');
    }

    public function refundTransaction()
    {
        return $this->belongsTo(EarningWalletTransaction::class, 'refund_transaction_id');
    }
}
