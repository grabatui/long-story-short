<?php

namespace App\Core\Domain\Authorization\Entity;

readonly class UserInit
{
    public function __construct(
        private int $id,
        private string $email
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
