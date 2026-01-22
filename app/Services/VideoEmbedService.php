<?php

namespace App\Services;

use App\Enums\VideoProvider;

class VideoEmbedService
{
    /**
     * Gera a URL de embed baseada no provedor (Enum).
     */
    public function getEmbedUrl(VideoProvider $provider, string $refId): string
    {
        return match ($provider) {
            VideoProvider::YOUTUBE => "https://www.youtube.com/embed/{$refId}?rel=0&modestbranding=1&showinfo=0",
            
            VideoProvider::VIMEO => "https://player.vimeo.com/video/{$refId}?title=0&byline=0&portrait=0&badge=0",
        };
    }
}