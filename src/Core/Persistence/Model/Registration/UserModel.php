<?php

namespace App\Core\Persistence\Model\Registration;

use App\Core\Domain\Registration\Entity\User as DomainUser;
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
