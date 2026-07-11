<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZenithPoolLevelIncome extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'level' => 'integer',
            'slots_required' => 'integer',
            'amount' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    public function node()
    {
        return $this->belongsTo(ZenithPoolNode::class, 'zenith_pool_node_id');
    }
}
