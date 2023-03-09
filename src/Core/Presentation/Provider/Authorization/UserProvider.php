<?php

namespace App\Core\Presentation\Provider\Authorization;

use App\Core\Domain\Authorization\Entity\UserInit;
use App\Core\Domain\Authorization\GetAuthorizedInitUserInterface;

readonly class UserProvider
{
    public function __construct(
        private GetAuthorizedInitUserInterface $getAuthorizedInitUser
    ) {
    }

    public function getAuthorizedInit(): UserInit
    {
        return $this->getAuthorizedInitUser->get();
    }
}
