<?php

namespace App\Core\Presentation\Formatter\v1\User;

use App\Core\Domain\Authorization\Entity\UserInit;
use App\Core\Presentation\Entity\Enum\UserTypeEnum;

readonly class GetInitFormatter
{
    public function format(UserInit $user): array
    {
        return [
            'id' => $user->getId(),
            'type' => UserTypeEnum::authorized->name,
            'email' => $user->getEmail(),
            'allows' => [],
        ];
    }
}
