<?php

namespace App\Core\Persistence\Action\Common\User;

use App\Core\Domain\Common\User\IsUserAuthorizedInterface;
use App\Core\Persistence\Repository\Adapter\SecurityRepository;

readonly class IsUserAuthorizedAction implements IsUserAuthorizedInterface
{
    public function __construct(
        private SecurityRepository $securityRepository
    ) {
    }

    public function is(): bool
    {
        return (bool) $this->securityRepository->getUser();
    }
}
