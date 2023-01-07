<?php

namespace App\Core\Domain\Common\Exception;

class NotFoundInterfaceException extends InterfaceException
{
    public function getStatusCode(): int
    {
        return 404;
    }
}
