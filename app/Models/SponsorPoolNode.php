<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SponsorPoolNode extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'position' => 'integer',
            'depth' => 'integer',
            'joined_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function purchaser()
    {
        return $this->belongsTo(User::class, 'purchaser_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('position');
    }

    public function levelIncomes()
    {
        return $this->hasMany(SponsorPoolLevelIncome::class);
    }

    public function packagePurchase()
    {
        return $this->belongsTo(PackagePurchase::class);
    }
}
