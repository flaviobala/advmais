<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'cover_image',
        'thumbnail',
        'course_video',
        'is_active',
        'category_id',
        'is_approved',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_approved' => 'boolean',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relacionamento: Um curso pertence a uma trilha (opcional).
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relacionamento: Um curso tem muitas aulas.
     */
    public function modules(): HasMany
    {
        return $this->hasMany(Module::class)->orderBy('order');
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }

    /**
     * Relacionamento: Um curso pertence a muitos grupos (turmas).
     */
    public function materials(): MorphMany
    {
        return $this->morphMany(Material::class, 'materialable')->orderBy('order');
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