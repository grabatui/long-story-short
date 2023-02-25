<?php

namespace App\Core\Persistence\Entity;

use App\Core\Persistence\Repository\MovieStaffRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: MovieStaffRepository::class)]
#[ORM\Table(name: '`movie_staffs`')]
class MovieStaff
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: false)]
    private ?string $title = null;

    #[ORM\Column(nullable: false)]
    private ?string $type = null;

    #[ORM\ManyToOne(inversedBy: 'staffItems')]
    private ?Movie $movie = null;

    public function __toString(): string
    {
        return sprintf('%s %s', $this->getType(), $this->getTitle());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function setMovie(?Movie $movie): void
    {
        $this->movie = $movie;
    }
}
