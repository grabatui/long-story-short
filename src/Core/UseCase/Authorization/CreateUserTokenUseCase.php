<?php

namespace App\Core\UseCase\Authorization;

use App\Core\Domain\Authorization\CreateTokenByUserIdInterface;

class CreateUserTokenUseCase
{
    public function __construct(
        private readonly CreateTokenByUserIdInterface $createTokenByUserId
    ) {
    }

    public function run(int $userId): string
    {
        return $this->createTokenByUserId->run($userId);
    }
}
