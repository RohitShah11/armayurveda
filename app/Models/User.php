<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['member_id','sponsor_id','state','city','package_name','main_wallet','earning_wallet','status','name', 'email', 'mobile','password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function profile()
    {
        return $this->hasOne(MemberProfile::class);
    }

    public function kyc()
    {
        return $this->hasOne(MemberKyc::class);
    }

    public function fundRequests()
    {
        return $this->hasMany(FundRequest::class);
    }

    public function zenithPoolNode()
    {
        return $this->hasOne(ZenithPoolNode::class);
    }

    public function directTreeNode()
    {
        return $this->hasOne(DirectTreeNode::class);
    }

    public function sponsorPoolNodes()
    {
        return $this->hasMany(SponsorPoolNode::class);
    }

    public function triggeredSponsorPoolNodes()
    {
        return $this->hasMany(SponsorPoolNode::class, 'purchaser_id');
    }
}
