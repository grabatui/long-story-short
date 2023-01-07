<?php

namespace App\Core\Domain\Common\Email;

interface GetDefaultEmailFromInterface
{
    public function get(): string;
}
