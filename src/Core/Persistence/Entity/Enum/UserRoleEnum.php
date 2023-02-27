<?php

namespace App\Core\Persistence\Entity\Enum;

enum UserRoleEnum: string
{
    case user = 'ROLE_USER';
    case admin = 'ROLE_ADMIN';
}
