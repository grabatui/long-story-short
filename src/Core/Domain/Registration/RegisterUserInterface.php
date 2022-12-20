<?php

namespace App\Core\Domain\Registration;

use App\Core\Domain\Registration\Entity\User;

interface RegisterUserInterface
{
    public function run(User $user, string $hashedPassword): void;
}
