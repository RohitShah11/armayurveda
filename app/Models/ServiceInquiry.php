<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceInquiry extends Model
{
    public const LOAN_TYPES = ['Personal Loan', 'Home Loan', 'Business Loan', 'Education Loan', 'Vehicle Loan', 'Loan Against Property', 'Other'];
    public const PURPOSES = ['Home Purchase / Renovation', 'Business Expansion', 'Education', 'Medical Expenses', 'Vehicle Purchase', 'Personal Needs', 'Other'];
    public const ROOM_RATE = 2000;

    protected $fillable = ['user_id', 'type', 'full_name', 'mobile', 'email', 'details', 'status', 'admin_note', 'reviewed_by', 'reviewed_at'];

    protected function casts(): array
    {
        return ['details' => 'array', 'reviewed_at' => 'datetime'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reference(): string
    {
        return ($this->type === 'hotel' ? 'HTL-' : 'LON-').str_pad((string) $this->id, 6, '0', STR_PAD_LEFT);
    }

    public static function statuses(string $type): array
    {
        return $type === 'hotel'
            ? ['Pending', 'Contacted', 'Confirmed', 'Unavailable', 'Cancelled']
            : ['Pending', 'Under Review', 'Contacted', 'Closed'];
    }
}
