<?php

namespace App\Core\Persistence\Action\Common\Email;

use App\Core\Domain\Common\Email\GetDefaultEmailFromInterface;
use App\Core\Domain\Common\Exception\NotFoundInterfaceException;

readonly class GetDefaultEmailFromAction implements GetDefaultEmailFromInterface
{
    /**
     * @throws NotFoundInterfaceException
     */
    public function get(): string
    {
        $result = getenv('MAIL_DEFAULT_FROM');

        if (!$result) {
            throw new NotFoundInterfaceException('Email по умолчанию не найден');
        }

        return $result;
    }
}
