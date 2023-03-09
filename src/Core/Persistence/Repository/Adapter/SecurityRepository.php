<?php

namespace App\Core\Persistence\Repository\Adapter;

use App\Core\Persistence\Entity\User;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class SecurityRepository
{
    public function __construct(
        private readonly Security $security
    ) {
    }

    public function getUser(): UserInterface|User|null
    {
        return $this->security->getUser();
    }
}
