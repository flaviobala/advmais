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
}