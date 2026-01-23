<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'cover_image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relacionamento: Um curso tem muitas aulas.
     */
    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }

    /**
     * Relacionamento: Um curso pertence a muitos grupos (turmas).
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'course_group')
                    ->withPivot('available_at')
                    ->withTimestamps();
    }

    /**
     * Scope: Filtra apenas cursos ativos.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Calcula o progresso do usuário neste curso (0-100%).
     */
    public function getProgressForUser($userId): int
    {
        $totalLessons = $this->lessons()->count();

        if ($totalLessons === 0) {
            return 0;
        }

        $completedLessons = $this->lessons()
            ->whereHas('users', function($query) use ($userId) {
                $query->where('user_id', $userId)
                      ->where('is_completed', true);
            })
            ->count();

        return (int) round(($completedLessons / $totalLessons) * 100);
    }
}