<?php

namespace App\Core\Domain\Search;

use App\Core\Domain\Search\Entity\MovieMainEntity;

interface GetMoviesByIdsInterface
{
    /**
     * @param int[] $ids
     * @return array<int, MovieMainEntity>
     */
    public function get(array $ids): array;
}
