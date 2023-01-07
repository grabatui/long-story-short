<?php

namespace App\Core\Persistence\Action\Authorization\ResetToken;

use App\Core\Domain\Authorization\ResetToken\Entity\ResetToken;
use App\Core\Domain\Authorization\ResetToken\MakeResetTokenByUserIdInterface;
use App\Core\Domain\Common\Exception\NotFoundInterfaceException;
use App\Core\Persistence\Model\Authorization\ResetTokenModel;
use App\Core\Persistence\Repository\Adapter\ResetTokenRepository;
use App\Core\Persistence\Repository\UserRepository;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;

readonly class MakeResetTokenByUserIdAction implements MakeResetTokenByUserIdInterface
{
    public function __construct(
        private UserRepository $userRepository,
        private ResetTokenRepository $resetTokenRepository,
        private ResetTokenModel $resetTokenModel
    ) {
    }

    /**
     * @throws NotFoundInterfaceException
     * @throws ResetPasswordExceptionInterface
     */
    public function run(int $userId): ResetToken
    {
        $user = $this->userRepository->find($userId);

        if (!$user) {
            throw new NotFoundInterfaceException('Пользователь не найден');
        }

        return $this->resetTokenModel->toDomain(
            $this->resetTokenRepository->getResetTokenByUser($user)
        );
    }
}
