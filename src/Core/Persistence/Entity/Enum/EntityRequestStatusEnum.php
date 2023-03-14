<?php

namespace App\Core\Persistence\Entity\Enum;

enum EntityRequestStatusEnum
{
    case new;
    case in_progress;
    case done;
    case rejected;
}
