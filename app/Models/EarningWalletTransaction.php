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
        'transaction_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
