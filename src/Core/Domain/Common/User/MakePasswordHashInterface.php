<?php

namespace App\Core\Domain\Common\User;

interface MakePasswordHashInterface
{
    public function run(string $password): string;
}
