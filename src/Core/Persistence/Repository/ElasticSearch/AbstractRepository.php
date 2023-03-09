<?php

namespace App\Core\Persistence\Repository\ElasticSearch;

use App\Core\Persistence\Entity\ElasticSearch\AbstractEntity;
use App\Core\Persistence\Entity\ElasticSearch\Movie;
use App\Core\Persistence\Entity\Enum\SearchIndexEnum;
use Elastica\Result;
use FOS\ElasticaBundle\Index\IndexManager;

abstract class AbstractRepository
{
    public function __construct(
        protected IndexManager $indexManager
    ) {
    }

    /**
     * @param string[] $terms
     * @return string
     */
    protected function prepareTermsForSearch(array $terms): string
    {
        return implode(' OR ', array_map(
            static fn (string $term): string => '*' . $term . '*',
            $terms
        ));
    }

    protected function makeEntity(Result $result): AbstractEntity
    {
        return match ((string)$result->getIndex()) {
            SearchIndexEnum::movies->value => $this->makeMovieEntity($result),
        };
    }

    protected function makeMovieEntity(Result $result): Movie
    {
        return new Movie(
            $result->getId(),
            SearchIndexEnum::from($result->getIndex()),
            $result->getScore(),
            $result->getSource()['title'] ?? '',
            $result->getSource()['originalTitle'] ?? null
        );
    }
}
