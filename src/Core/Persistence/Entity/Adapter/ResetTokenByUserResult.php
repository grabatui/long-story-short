<?php

namespace App\Core\Persistence\Entity\Adapter;

use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordToken;
use Throwable;

readonly class ResetTokenByUserResult
{
    public function __construct(
        private ?ResetPasswordToken $resetPasswordToken = null,
        private ?Throwable $exception = null
    ) {
    }

    public function getResetPasswordToken(): ?ResetPasswordToken
    {
        return $this->resetPasswordToken;
    }

    public function getException(): ?Throwable
    {
        return $this->exception;
    }
}
