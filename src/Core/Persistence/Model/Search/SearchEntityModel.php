<?php

namespace App\Core\Persistence\Model\Search;

use App\Core\Domain\Search\Entity\Enum\SearchEntityTypeEnum;
use App\Core\Domain\Search\Entity\SearchEntity;
use App\Core\Persistence\Entity\ElasticSearch\AbstractEntity;
use App\Core\Persistence\Entity\Enum\SearchIndexEnum;

class SearchEntityModel
{
    public function toDomain(AbstractEntity $mainEntity): SearchEntity
    {
        return new SearchEntity(
            $mainEntity->getId(),
            match ($mainEntity->getIndex()) {
                SearchIndexEnum::movies => SearchEntityTypeEnum::movies
            }
        );
    }
}
