<?php

namespace App\Core\Presentation\Provider\Entity;

use App\Core\Domain\Admin\Genre\Entity\Genre;
use App\Core\Domain\Search\GetAllGenresTitlesByCodesInterface;

readonly class GenreProvider
{
    public function __construct(
        private GetAllGenresTitlesByCodesInterface $getAllGenresTitlesByCodes
    ) {
    }

    /**
     * @return Genre[]
     */
    public function getAllGenresTitlesByCodes(): array
    {
        return $this->getAllGenresTitlesByCodes->get();
    }
}
