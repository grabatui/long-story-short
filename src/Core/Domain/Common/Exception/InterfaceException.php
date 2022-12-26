<?php

namespace App\Core\Domain\Common\Exception;

abstract class InterfaceException extends \Exception
{
    abstract public function getStatusCode(): int;
}
