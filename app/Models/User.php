<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\Models\Lesson;
use App\Models\Category;
use App\Models\Course;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $fillable = ['name', 'email', 'password', 'role', 'is_active'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isProfessor(): bool
    {
        return $this->role === 'professor';
    }

    public function canAccessAdmin(): bool
    {
        return in_array($this->role, ['admin', 'professor']);
    }

    // Relacionamento: Usuário pertence a vários grupos
    // groups removed

    /**
     * Relacionamento: Categorias que o usuário tem acesso.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'user_category')->withTimestamps();
    }

    /**
     * Relacionamento: Cursos que o usuário tem acesso direto.
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'user_course')->withTimestamps();
    }

    /**
     * Relacionamento: Aulas que o usuário assistiu/completou.
     */
    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class, 'lesson_user')
                    ->withPivot('is_completed', 'progress_percentage', 'completed_at')
                    ->withTimestamps();
    }

    /**
     * Relacionamento: Aulas com acesso direto individual.
     */
    public function accessibleLessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class, 'lesson_user_access')
                    ->withPivot('available_at')
                    ->withTimestamps();
    }

    public function hasAccessToCourse($courseId): bool
    {
        if ($this->canAccessAdmin()) {
            return true;
        }

        $course = Course::find($courseId);
        if (!$course || !$course->is_active) {
            return false;
        }

        if ($this->courses()->where('course_id', $courseId)->exists()) {
            return true;
        }

        if ($course->category_id && $this->categories()->where('category_id', $course->category_id)->exists()) {
            return true;
        }

        return false;
    }

    public function hasAccessToLesson($lessonId): bool
    {
        if ($this->canAccessAdmin()) {
            return true;
        }

        $lesson = Lesson::find($lessonId);
        if (!$lesson) {
            return false;
        }

        if ($this->hasAccessToCourse($lesson->course_id)) {
            return true;
        }

        return $this->accessibleLessons()->where('lessons.id', $lessonId)->exists();
    }

    /**
     * Verifica se o usuário tem acesso parcial a um curso (apenas algumas aulas).
     */
    public function hasPartialAccessToCourse($courseId): bool
    {
        if ($this->hasAccessToCourse($courseId)) {
            return false;
        }

        // Only direct user-accessible lessons are considered for partial access now
        return $this->accessibleLessons()
            ->where('course_id', $courseId)
            ->exists();
    }

    /**
     * Retorna as aulas acessíveis de um curso para este usuário.
     */
    public function getAccessibleLessonIdsForCourse($courseId): array
    {
        // Acesso completo = todas as aulas
        if ($this->hasAccessToCourse($courseId)) {
            return Lesson::where('course_id', $courseId)->pluck('id')->toArray();
        }

        // Only direct user-accessible lessons
        return $this->accessibleLessons()
            ->where('course_id', $courseId)
            ->pluck('lessons.id')
            ->unique()
            ->values()
            ->toArray();
    }
}