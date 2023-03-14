<?php

namespace App\Core\Domain\Authorization;

use App\Core\Domain\Authorization\Entity\UserInit;
use App\Core\Domain\Common\Exception\NotFoundInterfaceException;

interface GetAuthorizedInitUserInterface
{
    /**
     * @throws NotFoundInterfaceException
     */
    public function get(): UserInit;
}
