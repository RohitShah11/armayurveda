<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepurchaseCommissionLevel extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'level' => 'integer',
            'commission_percent' => 'decimal:2',
        ];
    }
}
