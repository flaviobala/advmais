<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Voucher extends Model
{
    protected $fillable = [
        'code',
        'description',
        'discount_percent',
        'applies_to',
        'category_id',
        'max_uses',
        'used_count',
        'is_active',
        'expires_at',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'expires_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Verifica se o voucher é válido para o plano anual da plataforma.
     */
    public function isValidFor(string $cycle = 'annual'): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        if ($this->max_uses > 0 && $this->used_count >= $this->max_uses) {
            return false;
        }

        if ($this->applies_to !== 'both' && $this->applies_to !== $cycle) {
            return false;
        }

        return true;
    }

    /**
     * Aplica desconto a um valor e retorna o valor final.
     */
    public function applyTo(float $amount): float
    {
        return round($amount * (1 - $this->discount_percent / 100), 2);
    }

    /**
     * Incrementa o contador de uso.
     */
    public function incrementUsage(): void
    {
        $this->increment('used_count');
    }
}
