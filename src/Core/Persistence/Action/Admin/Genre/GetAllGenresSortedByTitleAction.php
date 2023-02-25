<?php

namespace App\Core\Persistence\Action\Admin\Genre;

use App\Core\Domain\Admin\Genre\Entity\Genre as DomainGenre;
use App\Core\Domain\Admin\Genre\GetAllGenresSortedByTitleInterface;
use App\Core\Persistence\Entity\Genre;
use App\Core\Persistence\Model\Admin\Genre\GenreModel;
use App\Core\Persistence\Repository\GenreRepository;

readonly class GetAllGenresSortedByTitleAction implements GetAllGenresSortedByTitleInterface
{
    public function __construct(
        private GenreRepository $genreRepository,
        private GenreModel $genreModel
    ) {
    }

    public function get(): array
    {
        return array_map(
            fn(Genre $genre): DomainGenre => $this->genreModel->toDomain($genre),
            $this->genreRepository->getAllSortedByTitle()
        );
    }
}
