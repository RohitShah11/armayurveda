<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceInquiry extends Model
{
    public const LOAN_TYPES = ['Personal Loan', 'Home Loan', 'Business Loan', 'Education Loan', 'Vehicle Loan', 'Loan Against Property', 'Other'];
    public const PURPOSES = ['Home Purchase / Renovation', 'Business Expansion', 'Education', 'Medical Expenses', 'Vehicle Purchase', 'Personal Needs', 'Other'];
    public const ROOM_RATE = 2000;
    public const PROPERTY_TYPES = ['Residential', 'Commercial', 'Industrial', 'Agricultural', 'Other'];
    public const ROOF_TYPES = ['Concrete / RCC', 'Metal Sheet', 'Tile', 'Open Ground', 'Not Sure', 'Other'];

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
        $prefix = match ($this->type) {
            'hotel' => 'HTL-',
            'solar' => 'SOL-',
            default => 'LON-',
        };

        return $prefix.str_pad((string) $this->id, 6, '0', STR_PAD_LEFT);
    }

    public static function statuses(string $type): array
    {
        return match ($type) {
            'hotel' => ['Pending', 'Contacted', 'Confirmed', 'Unavailable', 'Cancelled'],
            'solar' => ['Pending', 'Under Review', 'Site Visit Scheduled', 'Quotation Sent', 'Closed'],
            default => ['Pending', 'Under Review', 'Contacted', 'Closed'],
        };
    }
}
