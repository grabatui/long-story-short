<?php

namespace App\Core\Domain\Authorization;

interface ChangeUserPasswordInterface
{
    public function run(int $userId, string $hashedPassword): void;
}
