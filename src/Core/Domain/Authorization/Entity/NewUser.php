<?php

namespace App\Core\Domain\Authorization\Entity;

class NewUser
{
    public function __construct(
        private readonly string $email,
        private readonly string $name,
        private readonly string $password
    ) {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
