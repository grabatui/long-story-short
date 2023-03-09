<?php

namespace App\Core\Persistence\Action\Search;

use App\Core\Domain\Search\GetMoviesByIdsInterface;
use App\Core\Persistence\Model\Search\MainEntityModel;
use App\Core\Persistence\Repository\MovieRepository;

readonly class GetMoviesByIdsAction implements GetMoviesByIdsInterface
{
    public function __construct(
        private MovieRepository $movieRepository,
        private MainEntityModel $mainEntityModel
    ) {
    }

    public function get(array $ids): array
    {
        $rows = $this->movieRepository->findBy(['id' => $ids]);

        $result = [];
        foreach ($rows as $row) {
            $result[$row->getId()] = $this->mainEntityModel->fromMovieToDomain($row);
        }

        return $result;
    }
}
