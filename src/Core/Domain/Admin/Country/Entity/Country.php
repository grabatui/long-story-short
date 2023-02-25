<?php

namespace App\Core\Domain\Admin\Country\Entity;

readonly class Country
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
