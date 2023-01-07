<?php

namespace App\Core\Persistence\Action\Authorization;

use App\Core\Domain\Authorization\CreateTokenByUserIdInterface;
use App\Core\Domain\Common\Exception\NotFoundInterfaceException;
use App\Core\Persistence\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

readonly class CreateTokenByUserIdAction implements CreateTokenByUserIdInterface
{
    public function __construct(
        private UserRepository $userRepository,
        private JWTTokenManagerInterface $JWTTokenManager
    ) {
    }

    /**
     * @param int $userId
     * @return string
     * @throws NotFoundInterfaceException
     */
    public function run(int $userId): string
    {
        $user = $this->userRepository->find($userId);

        if (!$user) {
            throw new NotFoundInterfaceException('Пользователь не найден');
        }

        return $this->JWTTokenManager->create($user);
    }
}
