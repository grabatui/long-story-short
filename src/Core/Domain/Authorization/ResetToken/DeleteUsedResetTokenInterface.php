<?php

namespace App\Core\Domain\Authorization\ResetToken;

interface DeleteUsedResetTokenInterface
{
    public function run(string $resetToken): void;
}
