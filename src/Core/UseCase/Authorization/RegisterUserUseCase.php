<?php

namespace App\Core\UseCase\Authorization;

use App\Core\Domain\Authorization\Entity\NewUser;
use App\Core\Domain\Authorization\RegisterUserInterface;
use App\Core\Domain\Common\Exception\CriticalInterfaceException;
use App\Core\Domain\Common\User\IsUserAuthorizedInterface;
use App\Core\Domain\Common\User\MakePasswordHashInterface;

class RegisterUserUseCase
{
    public function __construct(
        private readonly IsUserAuthorizedInterface $isUserAuthorized,
        private readonly MakePasswordHashInterface $makePasswordHash,
        private readonly RegisterUserInterface $registerUser
    ) {
    }

    /**
     * @throws CriticalInterfaceException
     */
    public function run(NewUser $user): void
    {
        if ($this->isUserAuthorized->is()) {
            throw new CriticalInterfaceException('Вы уже авторизованы');
        }

        $this->registerUser->run(
            $user,
            $this->makePasswordHash->run($user->getPassword())
        );
    }
}
