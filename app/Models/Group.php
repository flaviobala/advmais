<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'is_active',
    ];

    /**
     * Relacionamento: Um grupo tem muitos alunos (usuários).
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_user')->withTimestamps();
    }

    /**
     * Relacionamento: Um grupo tem acesso a muitos cursos.
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_group')
                    ->withPivot('available_at')
                    ->withTimestamps();
    }
}