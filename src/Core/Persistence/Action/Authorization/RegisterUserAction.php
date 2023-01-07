<?php

namespace App\Core\Persistence\Action\Authorization;

use App\Core\Domain\Authorization\Entity\NewUser;
use App\Core\Domain\Authorization\RegisterUserInterface;
use App\Core\Persistence\Model\Authorization\UserModel;
use App\Core\Persistence\Repository\UserRepository;

readonly class RegisterUserAction implements RegisterUserInterface
{
    public function __construct(
        private UserRepository $userRepository,
        private UserModel $userModel
    ) {
    }

    public function run(NewUser $user, string $hashedPassword): void
    {
        $this->userRepository->save(
            $this->userModel->toDatabase($user, $hashedPassword),
            true
        );
    }
}
