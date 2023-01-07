<?php

namespace App\Core\Persistence\Repository\Adapter;

use App\Core\Persistence\Entity\User;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordToken;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

readonly class ResetTokenRepository
{
    public function __construct(
        private ResetPasswordHelperInterface $resetPasswordHelper
    ) {
    }

    /**
     * @throws ResetPasswordExceptionInterface
     */
    public function getResetTokenByUser(User $user): ResetPasswordToken
    {
        return $this->resetPasswordHelper->generateResetToken($user);
    }
}
