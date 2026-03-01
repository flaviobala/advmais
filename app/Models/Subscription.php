<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'asaas_subscription_id',
        'status',
        'amount',
        'billing_type',
        'cycle',
        'next_due_date',
        'expires_at',
        'cancelled_at',
    ];

    protected $casts = [
        'amount'        => 'decimal:2',
        'next_due_date' => 'date',
        'expires_at'    => 'datetime',
        'cancelled_at'  => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Pagamentos relacionados a esta assinatura (o primeiro, usado para checkout).
     */
    public function payments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    public function isActive(): bool
    {
        if ($this->status !== 'active') {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        return true;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            });
    }
}
