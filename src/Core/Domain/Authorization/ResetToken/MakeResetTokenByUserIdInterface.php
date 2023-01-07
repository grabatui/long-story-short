<?php

namespace App\Core\Domain\Authorization\ResetToken;

use App\Core\Domain\Authorization\ResetToken\Entity\ResetToken;

interface MakeResetTokenByUserIdInterface
{
    public function run(int $userId): ResetToken;
}
