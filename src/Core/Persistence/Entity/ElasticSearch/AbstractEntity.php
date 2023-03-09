<?php

namespace App\Core\Persistence\Entity\ElasticSearch;

use App\Core\Persistence\Entity\Enum\SearchIndexEnum;

readonly abstract class AbstractEntity
{
    public function __construct(
        private int $id,
        private SearchIndexEnum $index,
        private float $score
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getIndex(): SearchIndexEnum
    {
        return $this->index;
    }

    public function getScore(): float
    {
        return $this->score;
    }
}
