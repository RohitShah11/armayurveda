<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class FundRequest extends Model
{
    protected $table = 'fund_requests';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
