<?php

namespace App\Core\Persistence\Action\Authorization\ResetToken;

use App\Core\Domain\Authorization\ResetToken\DeleteUsedResetTokenInterface;
use App\Core\Persistence\Repository\Adapter\ResetTokenRepository;

readonly class DeleteUsedResetTokenAction implements DeleteUsedResetTokenInterface
{
    public function __construct(
        private ResetTokenRepository $resetTokenRepository
    ) {
    }

    public function run(string $resetToken): void
    {
        $this->resetTokenRepository->deleteUsedResetToken($resetToken);
    }
}
