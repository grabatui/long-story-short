<?php

namespace App\Core\Domain\Authorization\ResetToken\Entity;

readonly class ResetToken
{
    public function __construct(
        private string $token,
        private \DateTimeInterface $expiresAt
    ) {
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getExpiresAt(): \DateTimeInterface
    {
        return $this->expiresAt;
    }
}
