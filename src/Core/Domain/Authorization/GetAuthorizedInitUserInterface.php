<?php

namespace App\Core\Domain\Authorization;

use App\Core\Domain\Authorization\Entity\UserInit;

interface GetAuthorizedInitUserInterface
{
    public function get(): UserInit;
}
