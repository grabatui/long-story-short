<?php

namespace App\Core\Persistence\Entity;

use App\Core\Persistence\Repository\CountryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
#[ORM\Table(name: '`countries`')]
class Country
{
    #[ORM\Id]
    #[ORM\Column]
    private ?string $code = null;

    #[ORM\Column(nullable: false)]
    private ?string $title = null;

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }
}
