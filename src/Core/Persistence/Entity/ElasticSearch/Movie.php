<?php

namespace App\Core\Persistence\Entity\ElasticSearch;

use App\Core\Persistence\Entity\Enum\SearchIndexEnum;

readonly class Movie extends AbstractEntity
{
    public function __construct(
        int $id,
        SearchIndexEnum $index,
        float $score,
        private string $title,
        private ?string $originalTitle
    ) {
        parent::__construct($id, $index, $score);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getOriginalTitle(): ?string
    {
        return $this->originalTitle;
    }
}
