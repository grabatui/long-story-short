<?php

namespace App\Core\Presentation\Entity\Enum;

enum EntityStaffTypeEnum: string
{
    case director = 'director';
    case actor = 'actor';
    case operator = 'operator';
    case screenwriter = 'screenwriter';
    case composer = 'composer';
    case artist = 'artist';
    case montage = 'montage';
    case producer = 'producer';

    public function getTitle(): string
    {
        return match ($this) {
            self::director => 'Режиссер',
            self::actor => 'Актер',
            self::operator => 'Оператор',
            self::screenwriter => 'Сценарий',
            self::composer => 'Композитор',
            self::artist => 'Художник',
            self::montage => 'Монтаж',
            self::producer => 'Продюсер',
        };
    }
}
