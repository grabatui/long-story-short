<?php

namespace App\Core\Presentation\Formatter\v1\Entity;

use App\Core\Domain\Search\Entity\AbstractMainEntity;
use App\Core\Presentation\Provider\Common\UrlProvider;
use App\Core\Presentation\Provider\Entity\GenreProvider;

readonly class SearchFormatter
{
    public function __construct(
        private UrlProvider $urlProvider,
        private GenreProvider $genreProvider
    ) {
    }

    /**
     * @param AbstractMainEntity[] $mainEntities
     * @return array
     */
    public function format(array $mainEntities): array
    {
        return [
            'items' => array_map(
                fn(AbstractMainEntity $entity): array => [
                    'id' => $entity->getId(),
                    'title' => $entity->getTitle(),
                    'original_title' => $entity->getOriginalTitle(),
                    'url' => $this->urlProvider->makeForMovie(
                        $entity->getSlug()
                    ),
                    'premiered_year' => $entity->getPremieredAt()->format('Y'),
                    'countries' => $entity->getCountries(),
                    'genres' => $this->getGenreTitles(
                        $entity->getGenres()
                    ),
                    // TODO: Make with different resolutions
                    'poster' => $this->urlProvider->makeForPoster(
                        $entity->getPosterName()
                    ),
                ],
                $mainEntities
            ),
        ];
    }

    /**
     * @param string[] $genresCodes
     * @return string[]
     */
    private function getGenreTitles(array $genresCodes): array
    {
        static $titles;

        if (is_null($titles)) {
            $titles = $this->genreProvider->getAllGenresTitlesByCodes();
        }

        $result = [];
        foreach ($genresCodes as $code) {
            $result[] = $titles[$code] ?? null;
        }

        $result = array_filter($result);

        sort($result);

        return $result;
    }
}
