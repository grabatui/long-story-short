<?php

namespace App\Core\UseCase\Registration;

use App\Core\Domain\Common\User\MakePasswordHashInterface;
use App\Core\Domain\Registration\Entity\User;
use App\Core\Domain\Registration\RegisterUserInterface;

class RegisterUserUseCase
{
    public function __construct(
        private readonly MakePasswordHashInterface $makePasswordHash,
        private readonly RegisterUserInterface $registerUser
    ) {
    }

    public function run(User $user): void
    {
        $this->registerUser->run(
            $user,
            $this->makePasswordHash->run($user->getPassword())
        );
    }
}
