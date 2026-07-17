<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRankReward extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'rank' => 'integer',
            'required_business' => 'decimal:2',
            'qualified_business' => 'decimal:2',
            'reward_amount' => 'decimal:2',
            'qualified_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function earningWalletTransaction()
    {
        return $this->belongsTo(EarningWalletTransaction::class);
    }
}
