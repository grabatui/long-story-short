<?php

namespace App\Core\Persistence\Model\Authorization;

use App\Core\Domain\Authorization\ResetToken\Entity\ResetToken;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordToken;

class ResetTokenModel
{
    public function toDomain(ResetPasswordToken $repositoryResetToken): ResetToken
    {
        return new ResetToken(
            $repositoryResetToken->getToken(),
            $repositoryResetToken->getExpiresAt()
        );
    }
}
