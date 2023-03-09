<?php

namespace App\Core\Domain\Search\Entity;

use DateTimeInterface;

abstract class AbstractMainEntity
{
    public function __construct(
        private readonly int $id,
        private readonly string $title,
        private readonly ?string $originalTitle,
        private readonly string $slug,
        private readonly DateTimeInterface $premieredAt,
        private readonly array $countries,
        private readonly array $genres,
        private readonly string $posterName
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getOriginalTitle(): ?string
    {
        return $this->originalTitle;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getPremieredAt(): DateTimeInterface
    {
        return $this->premieredAt;
    }

    public function getCountries(): array
    {
        return $this->countries;
    }

    public function getGenres(): array
    {
        return $this->genres;
    }

    public function getPosterName(): string
    {
        return $this->posterName;
    }
}
