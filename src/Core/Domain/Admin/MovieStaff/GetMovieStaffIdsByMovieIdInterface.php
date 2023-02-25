<?php

namespace App\Core\Domain\Admin\MovieStaff;

interface GetMovieStaffIdsByMovieIdInterface
{
    /**
     * @param int $id
     * @return int[]
     */
    public function get(int $id): array;
}
