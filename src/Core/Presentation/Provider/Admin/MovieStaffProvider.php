<?php

namespace App\Core\Presentation\Provider\Admin;

use App\Core\Domain\Admin\MovieStaff\GetMovieStaffIdsByMovieIdInterface;

readonly class MovieStaffProvider
{
    public function __construct(
        private GetMovieStaffIdsByMovieIdInterface $getMovieStaffIdsByMovieId
    ) {
    }

    /**
     * @param int $movieId
     * @return int[]
     */
    public function get(int $movieId): array
    {
        return $this->getMovieStaffIdsByMovieId->get($movieId);
    }
}
