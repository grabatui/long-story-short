<?php

namespace App\Core\Persistence\Repository\Adapter;

use App\Core\Persistence\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class HasherRepository
{
    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher
    ) {
    }

    public function getByRawPassword(string $password): string
    {
        $user = new User();

        return $this->userPasswordHasher->hashPassword($user, $password);
    }
}
