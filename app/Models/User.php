<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\Models\Lesson;

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

    // Relacionamento: Usuário pertence a vários grupos
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class);
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

    // HELPER DE SEGURANÇA: Verifica se o usuário pode ver o curso X
    public function hasAccessToCourse($courseId): bool
    {
        return $this->groups()
            ->whereHas('courses', function($query) use ($courseId) {
                $query->where('courses.id', $courseId);
            })
            ->exists();
    }
}