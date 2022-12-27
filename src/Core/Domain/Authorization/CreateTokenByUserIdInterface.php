<?php

namespace App\Core\Domain\Authorization;

use App\Core\Domain\Common\Exception\CriticalInterfaceException;

/**
 * @throws CriticalInterfaceException
 */
interface CreateTokenByUserIdInterface
{
    public function run(int $userId): string;
}
