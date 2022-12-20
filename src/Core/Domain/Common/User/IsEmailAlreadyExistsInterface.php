<?php

namespace App\Core\Domain\Common\User;

interface IsEmailAlreadyExistsInterface
{
    public function is(string $email): bool;
}
