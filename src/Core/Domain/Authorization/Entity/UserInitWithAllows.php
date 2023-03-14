<?php

namespace App\Core\Domain\Authorization\Entity;

use App\Core\Domain\Authorization\Entity\Enum\AllowEnum;

readonly class UserInitWithAllows
{
    /**
     * @param int|null $id
     * @param string|null $email
     * @param AllowEnum[] $allows
     */
    public function __construct(
        private ?int $id,
        private ?string $email,
        private array $allows
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getAllows(): array
    {
        return $this->allows;
    }
}
