<?php

namespace App\Core\Presentation\Entity\Enum;

enum ResponseTypeEnum: string
{
    case error = 'error';
    case output_error = 'output_error';
    case success = 'success';
}
