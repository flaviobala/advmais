<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutSetting extends Model
{
    protected $fillable = ['intro_video_url', 'intro_text', 'card_image'];

    public static function instance(): self
    {
        return self::firstOrCreate([]);
    }

    public function getIntroVideoEmbedUrlAttribute(): ?string
    {
        $url = $this->intro_video_url;
        if (!$url) return null;

        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $url, $m)) {
            return "https://www.youtube.com/embed/{$m[1]}?rel=0&modestbranding=1";
        }
        if (preg_match('/vimeo\.com\/(\d+)/', $url, $m)) {
            return "https://player.vimeo.com/video/{$m[1]}?byline=0&portrait=0";
        }

        return null;
    }
}
