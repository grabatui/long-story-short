<?php

namespace App\Core\Persistence\Action\Search;

use App\Core\Domain\Search\GetAllGenresTitlesByCodesInterface;
use App\Core\Persistence\Repository\GenreRepository;

readonly class GetAllGenresTitlesByCodesAction implements GetAllGenresTitlesByCodesInterface
{
    public function __construct(
        private GenreRepository $genreRepository
    ) {
    }

    public function get(): array
    {
        $items = $this->genreRepository->getAll();

        $result = [];
        foreach ($items as $item) {
            $result[$item->getCode()] = $item->getTitle();
        }

        return $result;
    }
}
