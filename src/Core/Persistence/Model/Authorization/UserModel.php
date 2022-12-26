<?php

namespace App\Core\Persistence\Model\Authorization;

use App\Core\Domain\Authorization\Entity\NewUser as DomainUser;
use App\Core\Persistence\Entity\User as DatabaseUser;

class UserModel
{
    public function toDatabase(DomainUser $domainEntity, string $hashedPassword): DatabaseUser
    {
        $entity = new DatabaseUser();
        $entity->setEmail($domainEntity->getEmail());
        $entity->setName($domainEntity->getName());
        $entity->setPassword($hashedPassword);

        return $entity;
    }
}
