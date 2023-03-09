<?php

namespace App\Core\Persistence\Action\Search;

use App\Core\Domain\Search\Entity\Enum\SearchEntityTypeEnum;
use App\Core\Domain\Search\Entity\SearchEntity;
use App\Core\Domain\Search\SearchMainEntitiesByTermAndTypeInterface;
use App\Core\Persistence\Entity\ElasticSearch\AbstractEntity;
use App\Core\Persistence\Model\Search\SearchEntityModel;
use App\Core\Persistence\Repository\ElasticSearch\MainEntityRepository;
use App\Core\Persistence\Repository\ElasticSearch\MovieRepository;
use App\Core\Persistence\Repository\ElasticSearch\SeriesRepository;

readonly class SearchMainEntitiesByTermAndTypeAction implements SearchMainEntitiesByTermAndTypeInterface
{
    public function __construct(
        private MainEntityRepository $mainEntityRepository,
        private MovieRepository $movieRepository,
        private SeriesRepository $seriesRepository,
        private SearchEntityModel $searchEntityModel
    ) {
    }

    public function get(array $termVariants, SearchEntityTypeEnum $type): array
    {
        $rows = match ($type) {
            SearchEntityTypeEnum::all => $this->mainEntityRepository->getAllByTerm($termVariants),
            SearchEntityTypeEnum::movies => $this->movieRepository->getAllByTerm($termVariants),
            SearchEntityTypeEnum::series => $this->seriesRepository->getAllByTerm($termVariants),
        };

        return array_map(
            fn (AbstractEntity $repositoryEntity): SearchEntity => $this->searchEntityModel->toDomain($repositoryEntity),
            $rows
        );
    }
}
