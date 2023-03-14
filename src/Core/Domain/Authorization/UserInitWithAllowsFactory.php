<?php

namespace App\Core\Domain\Authorization;

use App\Core\Domain\Authorization\Entity\Enum\AllowEnum;
use App\Core\Domain\Authorization\Entity\UserInit;
use App\Core\Domain\Authorization\Entity\UserInitWithAllows;

class UserInitWithAllowsFactory
{
    public function run(?UserInit $user): UserInitWithAllows
    {
        return new UserInitWithAllows(
            $user?->getId(),
            $user?->getEmail(),
            $this->makeAllows($user)
        );
    }

    private function makeAllows(?UserInit $user): array
    {
        $result = [];

        if ($user) {
            $result[] = AllowEnum::create_entity_request;
        }

        return $result;
    }
}
