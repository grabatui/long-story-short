<?php

namespace App\Core\Presentation\Provider\Common;

readonly class UrlProvider
{
    public function makeForMovie(string $slug): string
    {
        return sprintf('/movies/%s', $slug);
    }

    public function makeForPoster(string $fileName): string
    {
        return sprintf('/images/posters/%s', $fileName);
    }
}
