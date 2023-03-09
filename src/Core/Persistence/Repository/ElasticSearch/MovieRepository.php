<?php

namespace App\Core\Persistence\Repository\ElasticSearch;

use App\Core\Persistence\Entity\ElasticSearch\AbstractEntity;
use App\Core\Persistence\Entity\Enum\SearchIndexEnum;
use Elastica\Result;

class MovieRepository extends AbstractRepository
{
    /**
     * @param string[] $terms
     * @return AbstractEntity[]
     */
    public function getAllByTerm(array $terms): array
    {
        $search = $this->indexManager->getIndex(SearchIndexEnum::movies->value)
            ->createSearch(
                $this->prepareTermsForSearch($terms)
            );

        return array_map(
            fn (Result $result): AbstractEntity => $this->makeEntity($result),
            $search->search()->getResults()
        );
    }
}
