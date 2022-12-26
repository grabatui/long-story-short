<?php

namespace App\Http\Entity\Enum;

enum ResponseTypeEnum
{
    case error;
    case output_error;
    case success;
}
