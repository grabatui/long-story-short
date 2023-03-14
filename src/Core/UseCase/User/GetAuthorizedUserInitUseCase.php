<?php

namespace App\Core\UseCase\User;

use App\Core\Domain\Authorization\Entity\UserInitWithAllows;
use App\Core\Domain\Authorization\GetAuthorizedInitUserInterface;
use App\Core\Domain\Authorization\UserInitWithAllowsFactory;
use App\Core\Domain\Common\Exception\NotFoundInterfaceException;

readonly class GetAuthorizedUserInitUseCase
{
    public function __construct(
        private GetAuthorizedInitUserInterface $getAuthorizedInitUser,
        private UserInitWithAllowsFactory $userInitWithAllowsFactory
    ) {
    }

    public function get(): UserInitWithAllows
    {
        try {
            $user = $this->getAuthorizedInitUser->get();
        } catch (NotFoundInterfaceException) {
            $user = null;
        }

        return $this->userInitWithAllowsFactory->run($user);
    }
}
