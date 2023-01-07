<?php

namespace App\Core\Persistence\Action\Common\Email;

use App\Core\Domain\Common\Email\GetHelpEmailInterface;
use App\Core\Domain\Common\Exception\NotFoundInterfaceException;

readonly class GetHelpEmailAction implements GetHelpEmailInterface
{
    /**
     * @throws NotFoundInterfaceException
     */
    public function get(): string
    {
        $result = getenv('MAIL_HELP_EMAIL');

        if (!$result) {
            throw new NotFoundInterfaceException('Технический Email не найден');
        }

        return $result;
    }
}
