<?php

namespace App\Core\Presentation\Formatter\v1\User;

use App\Core\Domain\Authorization\Entity\Enum\AllowEnum;
use App\Core\Domain\Authorization\Entity\UserInitWithAllows;
use App\Core\Presentation\Entity\Enum\UserTypeEnum;

readonly class GetInitFormatter
{
    public function format(UserInitWithAllows $user): array
    {
        return [
            'id' => $user->getId(),
            'type' => $user->getId()
                ? UserTypeEnum::authorized->name
                : UserTypeEnum::unauthorized->name,
            'email' => $user->getEmail(),
            'allows' => array_map(
                static fn (AllowEnum $allow): string => $allow->name,
                $user->getAllows()
            ),
        ];
    }
}
