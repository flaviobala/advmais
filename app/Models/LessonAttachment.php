<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class LessonAttachment extends Model
{
    protected $fillable = [
        'lesson_id',
        'filename',
        'filepath',
        'filetype',
        'filesize',
        'order',
    ];

    /**
     * Relacionamento: Um anexo pertence a uma aula.
     */
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * Retorna a URL pública do arquivo.
     */
    public function getUrlAttribute(): string
    {
        return Storage::url($this->filepath);
    }

    /**
     * Retorna o tamanho formatado do arquivo.
     */
    public function getFormattedSizeAttribute(): string
    {
        $bytes = $this->filesize;
        
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    /**
     * Retorna o ícone baseado no tipo de arquivo.
     */
    public function getIconAttribute(): string
    {
        return match($this->filetype) {
            'pdf' => '<svg class="w-8 h-8 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 18h12a2 2 0 002-2V6l-4-4H4a2 2 0 00-2 2v12a2 2 0 002 2zm3-7h2v2H7v-2zm0-4h6v2H7V7z"/></svg>',
            'doc', 'docx' => '<svg class="w-8 h-8 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 18h12a2 2 0 002-2V6l-4-4H4a2 2 0 00-2 2v12a2 2 0 002 2zm3-7h6v2H7v-2zm0-4h6v2H7V7z"/></svg>',
            'xls', 'xlsx' => '<svg class="w-8 h-8 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 18h12a2 2 0 002-2V6l-4-4H4a2 2 0 00-2 2v12a2 2 0 002 2zm3-7h2v2H7v-2zm4 0h2v2h-2v-2zm-4-4h2v2H7V7zm4 0h2v2h-2V7z"/></svg>',
            'zip', 'rar' => '<svg class="w-8 h-8 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 18h12a2 2 0 002-2V6l-4-4H4a2 2 0 00-2 2v12a2 2 0 002 2zm5-11h2v2H9V7zm0 4h2v2H9v-2z"/></svg>',
            'mp4', 'webm', 'mov', 'avi' => '<svg class="w-8 h-8 text-purple-500" fill="currentColor" viewBox="0 0 20 20"><path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zm12.553 1.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/></svg>',
            'mp3', 'wav', 'ogg' => '<svg class="w-8 h-8 text-pink-500" fill="currentColor" viewBox="0 0 20 20"><path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/></svg>',
            'jpg', 'jpeg', 'png', 'gif', 'webp' => '<svg class="w-8 h-8 text-indigo-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/></svg>',
            default => '<svg class="w-8 h-8 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 18h12a2 2 0 002-2V6l-4-4H4a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>',
        };
    }

    /**
     * Detecta o tipo baseado na extensão.
     */
    public static function detectType(string $filename): string
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        return match($extension) {
            'pdf' => 'pdf',
            'doc', 'docx' => 'docx',
            'xls', 'xlsx' => 'xlsx',
            'zip', 'rar', '7z' => 'zip',
            'mp4', 'webm', 'mov', 'avi', 'mkv' => 'mp4',
            'mp3', 'wav', 'ogg', 'flac' => 'mp3',
            'jpg', 'jpeg', 'png', 'gif', 'webp', 'svg' => 'jpg',
            'ppt', 'pptx' => 'pptx',
            'txt' => 'txt',
            default => 'other',
        };
    }
}
