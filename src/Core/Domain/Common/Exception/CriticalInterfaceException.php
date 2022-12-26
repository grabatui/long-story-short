<?php

namespace App\Core\Domain\Common\Exception;

class CriticalInterfaceException extends InterfaceException
{
    public function getStatusCode(): int
    {
        return 500;
    }
}
