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

            VideoProvider::VIMEO => $this->buildVimeoEmbedUrl($refId),
        };
    }

    /**
     * Constrói a URL de embed do Vimeo.
     * Vídeos privados com hash: "1182369390/f07cb96307" → "...video/1182369390?h=f07cb96307"
     * Vídeos públicos: "76979871" → "...video/76979871"
     */
    private function buildVimeoEmbedUrl(string $refId): string
    {
        // Remove query params de share link (ex: ?share=copy&fl=sv&fe=ci)
        $clean = strtok($refId, '?');

        // Converte "videoId/hash" para o formato com parâmetro ?h=hash
        if (str_contains($clean, '/')) {
            [$videoId, $hash] = explode('/', $clean, 2);
            return "https://player.vimeo.com/video/{$videoId}?h={$hash}&title=0&byline=0&portrait=0&badge=0";
        }

        return "https://player.vimeo.com/video/{$clean}?title=0&byline=0&portrait=0&badge=0";
    }
}