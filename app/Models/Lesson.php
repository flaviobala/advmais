<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'module_id',
        'title',
        'description',
        'order',
        'video_provider',
        'video_ref_id',
        'duration_seconds',
        'attachment',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relacionamento: Uma aula pertence a um curso.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Relacionamento: Usuários que assistiram/completaram esta aula.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'lesson_user')
                    ->withPivot('is_completed', 'progress_percentage', 'completed_at')
                    ->withTimestamps();
    }

    /**
     * Relacionamento: Grupos que têm acesso direto a esta aula.
     */
    // groups removed

    /**
     * Relacionamento: Usuários que têm acesso direto a esta aula.
     */
    public function accessUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'lesson_user_access')
                    ->withPivot('available_at')
                    ->withTimestamps();
    }

    /**
     * Relacionamento: Anexos/arquivos complementares da aula.
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(LessonAttachment::class)->orderBy('order');
    }
}