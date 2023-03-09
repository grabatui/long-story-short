<?php

namespace App\Core\Domain\Search;

use App\Core\Domain\Common\Exception\CriticalInterfaceException;
use App\Core\Domain\Search\Entity\AbstractMainEntity;
use App\Core\Domain\Search\Entity\Enum\SearchEntityTypeEnum;
use App\Core\Domain\Search\Entity\SearchEntity;

readonly class MainEntityFactory
{
    public function __construct(
        private GetMoviesByIdsInterface $getMoviesByIds
    ) {
    }

    /**
     * @param SearchEntity[] $searchEntities
     * @return AbstractMainEntity[]
     * @throws CriticalInterfaceException
     */
    public function fromSearchEntities(array $searchEntities): array
    {
        $entityIdsByType = $this->groupSearchEntitiesByType($searchEntities);

        $movieEntities = (!empty($entityIdsByType[SearchEntityTypeEnum::movies->value]))
            ? $this->getMoviesByIds->get($entityIdsByType[SearchEntityTypeEnum::movies->value])
            : [];
        $seriesEntities = []; // TODO

        return array_filter(
            array_map(
                static fn (SearchEntity $searchEntity) => match ($searchEntity->getSearchType()) {
                    SearchEntityTypeEnum::movies => $movieEntities[$searchEntity->getId()] ?? null,
                    SearchEntityTypeEnum::series => $seriesEntities[$searchEntity->getId()] ?? null,
                    SearchEntityTypeEnum::all => throw new CriticalInterfaceException('It is not possible'),
                },
                $searchEntities
            )
        );
    }

    /**
     * @param SearchEntity[] $searchEntities
     * @return array<string, int[]>
     */
    private function groupSearchEntitiesByType(array $searchEntities): array
    {
        $result = [];
        foreach ($searchEntities as $searchEntity) {
            $searchType = $searchEntity->getSearchType()->value;

            if (!array_key_exists($searchType, $result)) {
                $result[$searchType] = [];
            }

            $result[$searchType][] = $searchEntity->getId();
        }

        return $result;
    }
}
