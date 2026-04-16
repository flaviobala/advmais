<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class MemberOnboarding extends Model
{
    protected $fillable = [
        'user_id', 'token', 'status',
        'welcome_sent_at', 'photo', 'mini_bio', 'oab_number',
        'signed_term', 'term_accepted_at', 'docs_submitted_at',
        'approved_at', 'approved_by', 'notes',
    ];

    protected $casts = [
        'welcome_sent_at'  => 'datetime',
        'term_accepted_at' => 'datetime',
        'docs_submitted_at'=> 'datetime',
        'approved_at'      => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public static function createForUser(User $user): static
    {
        return static::create([
            'user_id' => $user->id,
            'token'   => Str::random(64),
            'status'  => 'pending',
        ]);
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'pending'  => 'Aguardando documentos',
            'received' => 'Documentos recebidos',
            'approved' => 'Aprovado',
            default    => $this->status,
        };
    }

    public function statusColor(): string
    {
        return match ($this->status) {
            'pending'  => 'yellow',
            'received' => 'blue',
            'approved' => 'green',
            default    => 'gray',
        };
    }

    public function hasDocuments(): bool
    {
        return $this->docs_submitted_at !== null;
    }
}
