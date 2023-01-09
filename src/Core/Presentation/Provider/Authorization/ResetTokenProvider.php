<?php

namespace App\Core\Presentation\Provider\Authorization;

use App\Core\Domain\Authorization\ResetToken\IsResetTokenValidInterface;

readonly class ResetTokenProvider
{
    public function __construct(
        private IsResetTokenValidInterface $isResetTokenValid
    ) {
    }

    public function isResetTokenValid(string $resetToken): bool
    {
        return $this->isResetTokenValid->is($resetToken);
    }
}
