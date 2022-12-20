<?php

namespace App\Core\Persistence\Action\Common\User;

use App\Core\Domain\Common\User\IsEmailAlreadyExistsInterface;
use App\Core\Persistence\Repository\UserRepository;

class IsEmailAlreadyExistsAction implements IsEmailAlreadyExistsInterface
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    public function is(string $email): bool
    {
        return (bool) $this->userRepository->findOneBy(['email' => $email]);
    }
}
