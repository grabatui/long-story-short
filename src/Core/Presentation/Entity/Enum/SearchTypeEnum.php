<?php

namespace App\Core\Presentation\Entity\Enum;

enum SearchTypeEnum: string
{
    case all = 'Все';
    case movies = 'Фильмы';
    case series = 'Сериалы';

    public function getPlaceholder(): string
    {
        return match ($this) {
            self::all => 'Начните печатать название фильма или сериала',
            self::movies => 'Начните печатать название фильма',
            self::series => 'Начните печатать название сериала',
        };
    }
}
