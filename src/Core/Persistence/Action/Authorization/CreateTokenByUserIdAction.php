<?php

namespace App\Core\Persistence\Action\Authorization;

use App\Core\Domain\Authorization\CreateTokenByUserIdInterface;
use App\Core\Domain\Common\Exception\CriticalInterfaceException;
use App\Core\Persistence\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class CreateTokenByUserIdAction implements CreateTokenByUserIdInterface
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly JWTTokenManagerInterface $JWTTokenManager
    ) {
    }

    /**
     * @param int $userId
     * @return string
     * @throws CriticalInterfaceException
     */
    public function run(int $userId): string
    {
        $user = $this->userRepository->find($userId);

        if (!$user) {
            throw new CriticalInterfaceException('Пользователь не найден');
        }

        return $this->JWTTokenManager->create($user);
    }
}
