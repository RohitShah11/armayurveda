<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class MemberProfile extends Model
{
    protected $fillable = [
        'user_id',
        'mobile',
        'dob',
        'gender',
        'address',
        'state',
        'city',
        'pin_code',
        'nominee_name',
        'nominee_relation',
        'profile_photo'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
