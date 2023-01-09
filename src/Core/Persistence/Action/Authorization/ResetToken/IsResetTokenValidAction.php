<?php

namespace App\Core\Persistence\Action\Authorization\ResetToken;

use App\Core\Domain\Authorization\ResetToken\IsResetTokenValidInterface;
use App\Core\Persistence\Repository\Adapter\ResetTokenRepository;

readonly class IsResetTokenValidAction implements IsResetTokenValidInterface
{
    public function __construct(
        private ResetTokenRepository $resetTokenRepository
    ) {
    }

    public function is(string $resetToken): bool
    {
        return $this->resetTokenRepository->isResetTokenIsValid($resetToken);
    }
}
