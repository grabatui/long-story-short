<?php

namespace App\Core\Persistence\Action\Registration;

use App\Core\Domain\Registration\Entity\User;
use App\Core\Domain\Registration\RegisterUserInterface;
use App\Core\Persistence\Model\Registration\UserModel;
use App\Core\Persistence\Repository\UserRepository;

class RegisterUserAction implements RegisterUserInterface
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserModel $userModel
    ) {
    }

    public function run(User $user, string $hashedPassword): void
    {
        $this->userRepository->save(
            $this->userModel->toDatabase($user, $hashedPassword),
            true
        );
    }
}
