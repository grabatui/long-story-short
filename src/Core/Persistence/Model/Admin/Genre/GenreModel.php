<?php

namespace App\Core\Persistence\Model\Admin\Genre;

use App\Core\Domain\Admin\Genre\Entity\Genre as DomainGenre;
use App\Core\Persistence\Entity\Genre;

class GenreModel
{
    public function toDomain(Genre $genre): DomainGenre
    {
        return new DomainGenre(
            $genre->getCode(),
            $genre->getTitle()
        );
    }
}
