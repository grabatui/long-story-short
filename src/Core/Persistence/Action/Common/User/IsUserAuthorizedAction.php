<?php

namespace App\Core\Persistence\Action\Common\User;

use App\Core\Domain\Common\User\IsUserAuthorizedInterface;
use Symfony\Component\Security\Core\Security;

class IsUserAuthorizedAction implements IsUserAuthorizedInterface
{
    public function __construct(
        private readonly Security $security
    ) {
    }

    public function is(): bool
    {
        return (bool) $this->security->getUser();
    }
}
