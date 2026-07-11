<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageCommissionLevel extends Model
{
    protected $table = 'package_commission_levels';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'level' => 'integer',
            'commission_amount' => 'decimal:2',
        ];
    }
}
