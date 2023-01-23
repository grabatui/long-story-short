<?php

namespace App\Core\Persistence\Action\Authorization\ResetToken;

use App\Core\Domain\Authorization\ResetToken\Entity\ResetToken;
use App\Core\Domain\Authorization\ResetToken\MakeResetTokenByUserIdInterface;
use App\Core\Domain\Common\Exception\NotFoundInterfaceException;
use App\Core\Persistence\Model\Authorization\ResetTokenModel;
use App\Core\Persistence\Repository\Adapter\ResetTokenRepository;
use App\Core\Persistence\Repository\UserRepository;
use Throwable;

readonly class MakeResetTokenByUserIdAction implements MakeResetTokenByUserIdInterface
{
    public function __construct(
        private UserRepository $userRepository,
        private ResetTokenRepository $resetTokenRepository,
        private ResetTokenModel $resetTokenModel
    ) {
    }

    /**
     * @throws Throwable
     */
    public function run(int $userId): ResetToken
    {
        $user = $this->userRepository->find($userId);

        if (!$user) {
            throw new NotFoundInterfaceException('Пользователь не найден');
        }

        $tokenResult = $this->resetTokenRepository->getResetTokenByUser($user);

        if ($tokenResult->getException()) {
            throw $tokenResult->getException();
        }

        return $this->resetTokenModel->toDomain(
            $tokenResult->getResetPasswordToken()
        );
    }
}
