<?php

namespace App\Core\Persistence\Action\Authorization\ResetToken;

use App\Core\Domain\Authorization\ResetToken\GetUserIdByResetTokenInterface;
use App\Core\Domain\Common\Exception\NotFoundInterfaceException;
use App\Core\Persistence\Repository\Adapter\ResetTokenRepository;

readonly class GetUserIdByResetTokenAction implements GetUserIdByResetTokenInterface
{
    public function __construct(
        private ResetTokenRepository $resetTokenRepository
    ) {
    }

    /**
     * @throws NotFoundInterfaceException
     */
    public function get(string $resetToken): int
    {
        $user = $this->resetTokenRepository->getUserByResetToken($resetToken);

        if (!$user) {
            throw new NotFoundInterfaceException('Пользователь не найден');
        }

        return $user->getId();
    }
}
