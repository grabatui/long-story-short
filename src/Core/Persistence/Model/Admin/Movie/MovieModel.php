<?php

namespace App\Core\Persistence\Model\Admin\Movie;

use App\Core\Domain\Admin\Movie\Entity\Movie as DomainMovie;
use App\Core\Persistence\Entity\Movie;

class MovieModel
{
    public function toDomain(Movie $movie): DomainMovie
    {
        return new DomainMovie(
            $movie->getId(),
            $movie->getTitle(),
            $movie->getOriginalTitle()
        );
    }
}
