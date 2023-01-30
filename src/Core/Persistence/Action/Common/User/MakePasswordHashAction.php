<?php

namespace App\Core\Persistence\Action\Common\User;

use App\Core\Domain\Common\User\MakePasswordHashInterface;
use App\Core\Persistence\Repository\Adapter\HasherRepository;

readonly class MakePasswordHashAction implements MakePasswordHashInterface
{
    public function __construct(
        private HasherRepository $hasherRepository
    ) {
    }

    public function run(string $password): string
    {
        return $this->hasherRepository->getByRawPassword($password);
    }
}
