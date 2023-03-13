<?php

namespace App\Tests\Feature\Traits;

use App\Core\Persistence\Entity\Movie;
use DateTime;

trait EntityTrait
{
    /**
     * @Then в базе данных есть фильмы из :dataPath
     */
    public function thereAreMoviesInDatabaseFrom(string $dataPath): void
    {
        $moviesData = json_decode($this->getAndCheckDataFilePath($dataPath), true);

        foreach ($moviesData as $movie) {
            $movieEntity = new Movie();
            $movieEntity->setTitle($movie['title']);
            $movieEntity->setOriginalTitle($movie['original_title']);
            $movieEntity->setSlug($movie['slug']);
            $movieEntity->setPremieredAt(new DateTime($movie['premiered_at']));
            $movieEntity->setCountries(json_decode($movie['countries'], true));
            $movieEntity->setGenres(json_decode($movie['genres'], true));
            $movieEntity->setDurationInMinutes($movie['duration_in_minutes']);
            $movieEntity->setCreatedAt(new DateTime($movie['created_at']));
            $movieEntity->setUpdatedAt(new DateTime($movie['updated_at']));
            $movieEntity->setPosterName($movie['poster_name']);
            $movieEntity->setPosterSize($movie['poster_size']);

            $this->movieRepository->save($movieEntity, true);
        }
    }
}
