<?php

namespace App\Core\Persistence\Repository\ElasticSearch;

use App\Core\Persistence\Entity\ElasticSearch\AbstractEntity;

class SeriesRepository extends AbstractRepository
{
    /**
     * @param string[] $terms
     * @return AbstractEntity[]
     */
    public function getAllByTerm(array $terms): array
    {
        // TODO
        return [];
    }
}
