<?php

namespace App\Core\Persistence\Entity;

readonly class Genre
{
    public function __construct(
        private string $code,
        private string $title
    ) {
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
