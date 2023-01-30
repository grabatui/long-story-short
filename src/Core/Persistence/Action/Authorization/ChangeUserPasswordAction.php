<?php

namespace App\Core\Persistence\Action\Authorization;

use App\Core\Domain\Authorization\ChangeUserPasswordInterface;
use App\Core\Domain\Common\Exception\NotFoundInterfaceException;
use App\Core\Persistence\Repository\UserRepository;

readonly class ChangeUserPasswordAction implements ChangeUserPasswordInterface
{
    public function __construct(
        private UserRepository $userRepository
    ) {
    }

    /**
     * @throws NotFoundInterfaceException
     */
    public function run(int $userId, string $hashedPassword): void
    {
        $user = $this->userRepository->find($userId);

        if (!$user) {
            throw new NotFoundInterfaceException('Пользователь не найден');
        }

        $this->userRepository->upgradePassword($user, $hashedPassword);
    }
}
