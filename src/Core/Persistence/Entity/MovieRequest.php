<?php

namespace App\Core\Persistence\Entity;

use App\Core\Persistence\Entity\Enum\EntityRequestStatusEnum;
use App\Core\Persistence\Repository\MovieRequestRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: MovieRequestRepository::class)]
#[ORM\Table(name: '`movie_requests`')]
class MovieRequest
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: false)]
    private ?string $link = null;

    #[ORM\Column(nullable: false)]
    private ?string $status = EntityRequestStatusEnum::new->name;

    #[ORM\Column(nullable: true)]
    private ?string $comment = null;

    #[ORM\ManyToOne(inversedBy: 'movieRequests')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): void
    {
        $this->link = $link;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): void
    {
        $this->user = $user;
    }
}
