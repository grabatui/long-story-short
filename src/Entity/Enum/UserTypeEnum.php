<?php

namespace App\Entity\Enum;

enum UserTypeEnum
{
    case unauthorized;
    case authorized;
    case admin;
}
