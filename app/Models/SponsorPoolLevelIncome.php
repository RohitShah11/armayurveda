<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SponsorPoolLevelIncome extends Model
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
        return $this->belongsTo(SponsorPoolNode::class, 'sponsor_pool_node_id');
    }
}
