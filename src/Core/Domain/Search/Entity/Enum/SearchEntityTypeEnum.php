<?php

namespace App\Core\Domain\Search\Entity\Enum;

enum SearchEntityTypeEnum: string
{
    case all = 'all';
    case movies = 'movies';
    case series = 'series';
}
