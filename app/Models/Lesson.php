<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'order',
        'video_provider',
        'video_ref_id',
        'duration_seconds',
    ];

    /**
     * Relacionamento: Uma aula pertence a um curso.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}