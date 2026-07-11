<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MainWalletTransaction extends Model
{
    protected $table = 'main_wallet_transactions';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'transaction_date' => 'datetime',
            'amount' => 'decimal:2',
            'opening_balance' => 'decimal:2',
            'closing_balance' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fundRequest()
    {
        return $this->belongsTo(FundRequest::class);
    }
}
