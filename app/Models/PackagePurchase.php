<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackagePurchase extends Model
{
    protected $table = 'package_purchases';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'package_price' => 'decimal:2',
            'purchase_date' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function sponsorPoolNode()
    {
        return $this->hasOne(SponsorPoolNode::class);
    }
}
