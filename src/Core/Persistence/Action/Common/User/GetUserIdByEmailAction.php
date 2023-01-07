<?php

namespace App\Core\Persistence\Action\Common\User;

use App\Core\Domain\Common\Exception\NotFoundInterfaceException;
use App\Core\Domain\Common\User\GetUserIdByEmailInterface;
use App\Core\Persistence\Repository\UserRepository;

readonly class GetUserIdByEmailAction implements GetUserIdByEmailInterface
{
    public function __construct(
        private UserRepository $userRepository
    ) {
    }

    /**
     * @throws NotFoundInterfaceException
     */
    public function get(string $email): int
    {
        $user = $this->userRepository->findOneBy(['email' => $email]);

        if (!$user) {
            throw new NotFoundInterfaceException('Пользователь не найден');
        }

        return $user->getId();
    }
}
