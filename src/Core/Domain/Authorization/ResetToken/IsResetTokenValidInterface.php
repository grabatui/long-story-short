<?php

namespace App\Core\Domain\Authorization\ResetToken;

interface IsResetTokenValidInterface
{
    public function is(string $resetToken): bool;
}
