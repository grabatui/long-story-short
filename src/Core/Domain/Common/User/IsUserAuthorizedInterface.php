<?php

namespace App\Core\Domain\Common\User;

interface IsUserAuthorizedInterface
{
    public function is(): bool;
}
