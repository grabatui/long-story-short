<?php

namespace App\Core\Domain\Authorization;

use App\Core\Domain\Authorization\Entity\NewUser;

interface RegisterUserInterface
{
    public function run(NewUser $user, string $hashedPassword): void;
}
