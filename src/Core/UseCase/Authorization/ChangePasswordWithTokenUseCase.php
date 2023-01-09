<?php

namespace App\Core\UseCase\Authorization;

use App\Core\Domain\Authorization\ChangeUserPasswordInterface;
use App\Core\Domain\Authorization\ResetToken\DeleteUsedResetTokenInterface;
use App\Core\Domain\Authorization\ResetToken\GetUserIdByResetTokenInterface;
use App\Core\Domain\Common\User\MakePasswordHashInterface;

readonly class ChangePasswordWithTokenUseCase
{
    public function __construct(
        private GetUserIdByResetTokenInterface $getUserIdByResetToken,
        private MakePasswordHashInterface $makePasswordHash,
        private ChangeUserPasswordInterface $changeUserPassword,
        private DeleteUsedResetTokenInterface $deleteUsedResetToken
    ) {
    }

    public function run(string $resetToken, string $password): void
    {
        $userId = $this->getUserIdByResetToken->get($resetToken);

        $this->changeUserPassword->run(
            $userId,
            $this->makePasswordHash->run($password)
        );

        $this->deleteUsedResetToken->run($resetToken);
    }
}
