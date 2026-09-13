<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductOrder extends Model
{
    public const STATUSES = ['Pending', 'Confirmed', 'Processing', 'Shipped', 'Delivered', 'Cancelled'];

    public const STATUS_TRANSITIONS = [
        'Pending' => ['Confirmed', 'Processing', 'Shipped', 'Delivered', 'Cancelled'],
        'Confirmed' => ['Processing', 'Shipped', 'Delivered', 'Cancelled'],
        'Processing' => ['Shipped', 'Delivered', 'Cancelled'],
        'Shipped' => ['Delivered', 'Cancelled'],
        'Delivered' => [],
        'Cancelled' => [],
    ];

    protected $guarded = [];

    protected function casts(): array
    {
        return ['unit_price' => 'decimal:2', 'total_amount' => 'decimal:2', 'ordered_at' => 'datetime'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function availableStatuses(): array
    {
        return self::STATUS_TRANSITIONS[$this->status] ?? [];
    }
}
