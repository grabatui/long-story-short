<?php

namespace App\Core\Domain\Common\User;

interface GetUserIdByEmailInterface
{
    public function get(string $email): int;
}
