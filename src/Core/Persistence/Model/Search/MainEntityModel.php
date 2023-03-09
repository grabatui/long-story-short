<?php

namespace App\Core\Persistence\Model\Search;

use App\Core\Domain\Search\Entity\AbstractMainEntity;
use App\Core\Domain\Search\Entity\MovieMainEntity;
use App\Core\Persistence\Entity\Movie;

class MainEntityModel
{
    public function fromMovieToDomain(Movie $movie): AbstractMainEntity
    {
        return new MovieMainEntity(
            $movie->getId(),
            $movie->getTitle(),
            $movie->getOriginalTitle(),
            $movie->getSlug(),
            $movie->getPremieredAt(),
            $movie->getCountries(),
            $movie->getGenres(),
            $movie->getPosterName()
        );
    }
}
