<?php

namespace App\Core\Domain\Admin\Genre;

use App\Core\Domain\Admin\Genre\Entity\Genre;

interface GetAllGenresSortedByTitleInterface
{
    /**
     * @return Genre[]
     */
    public function get(): array;
}
