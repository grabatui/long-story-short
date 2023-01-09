<?php

namespace App\Core\Domain\Authorization\ResetToken;

interface GetUserIdByResetTokenInterface
{
    public function get(string $resetToken): int;
}
