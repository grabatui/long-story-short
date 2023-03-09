<?php

namespace App\Core\Domain\Search\Entity;

use App\Core\Domain\Search\Entity\Enum\SearchEntityTypeEnum;

readonly class SearchEntity
{
    public function __construct(
        private int $id,
        private SearchEntityTypeEnum $searchType
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSearchType(): SearchEntityTypeEnum
    {
        return $this->searchType;
    }
}
