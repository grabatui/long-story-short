<?php

namespace App\Core\Persistence\Repository\Adapter;

use App\Core\Persistence\Entity\Adapter\ResetTokenByUserResult;
use App\Core\Persistence\Entity\User;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

readonly class ResetTokenRepository
{
    public function __construct(
        private ResetPasswordHelperInterface $resetPasswordHelper
    ) {
    }

    public function getResetTokenByUser(User $user): ResetTokenByUserResult
    {
        try {
            return new ResetTokenByUserResult(
                resetPasswordToken: $this->resetPasswordHelper->generateResetToken($user)
            );
        } catch (ResetPasswordExceptionInterface $exception) {
            return new ResetTokenByUserResult(
                exception: $exception
            );
        }
    }

    public function isResetTokenIsValid(string $resetToken): bool
    {
        try {
            $this->resetPasswordHelper->validateTokenAndFetchUser($resetToken);
        } catch (ResetPasswordExceptionInterface) {
            return false;
        }

        return true;
    }

    public function getUserByResetToken(string $resetToken): ?User
    {
        try {
            /** @var User $user */
            $user = $this->resetPasswordHelper->validateTokenAndFetchUser($resetToken);

            return $user;
        } catch (ResetPasswordExceptionInterface) {}

        return null;
    }

    public function deleteUsedResetToken(string $resetToken): void
    {
        $this->resetPasswordHelper->removeResetRequest($resetToken);
    }
}
