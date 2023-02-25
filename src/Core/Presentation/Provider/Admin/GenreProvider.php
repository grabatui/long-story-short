<?php

namespace App\Core\Presentation\Provider\Admin;

use App\Core\Domain\Admin\Genre\Entity\Genre;
use App\Core\Domain\Admin\Genre\GetAllGenresSortedByTitleInterface;

readonly class GenreProvider
{
    public function __construct(
        private GetAllGenresSortedByTitleInterface $getAllGenresSortedByTitle
    ) {
    }

    /**
     * @return Genre[]
     */
    public function getAllSortedByTitle(): array
    {
        return $this->getAllGenresSortedByTitle->get();
    }
}
