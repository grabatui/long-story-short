<?php

namespace App\Core\Persistence\Repository;

use App\Core\Persistence\Entity\Genre;

class GenreRepository
{
    private const RAW_DATA = [
        'comedy' => 'Комедия',
        'horror' => 'Ужасы',
        'action' => 'Боевик',
        'animation' => 'Анимация',
        'biography' => 'Биография',
        'western' => 'Вестерн',
        'war' => 'Военный',
        'detective' => 'Детектив',
        'documentary' => 'Документальный',
        'history' => 'Исторический',
        'short' => 'Короткометражный',
        'criminal' => 'Криминал',
        'sci-fi' => 'Фантастика',
        'thriller' => 'Триллер',
        'romance' => 'Мелодрама',
        'adventure' => 'Приключения',
        'family' => 'Семейный',
        'anime' => 'Аниме',
        'drama' => 'Драма',
        'sport' => 'Спорт',
        'music' => 'Музыкальный',
    ];

    /**
     * @return Genre[]
     */
    public function getAll(): array
    {
        static $result;

        if (!is_null($result)) {
            return $result;
        }

        $result = [];
        foreach (self::RAW_DATA as $code => $title) {
            $result[] = new Genre($code, $title);
        }

        return $result;
    }

    /**
     * @return Genre[]
     */
    public function getAllSortedByTitle(): array
    {
        $items = $this->getAll();

        uasort(
            $items,
            static fn (Genre $aGenre, Genre $bGenre): int => $aGenre->getTitle() <=> $bGenre->getTitle()
        );

        return $items;
    }
}
