<?php

namespace App\Core\Persistence\Entity;

use App\Core\Persistence\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
#[ORM\Table(name: '`movies`')]
#[Vich\Uploadable]
class Movie
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: false)]
    private ?string $title = null;

    #[ORM\Column(nullable: true)]
    private ?string $originalTitle = null;

    #[ORM\Column(unique: true, nullable: false)]
    private ?string $slug = null;

    #[ORM\Column(type: 'date', nullable: false)]
    private ?\DateTimeInterface $premieredAt = null;

    #[ORM\Column(nullable: false)]
    private array $countries = [];

    #[ORM\Column(nullable: false)]
    private array $genres = [];

    #[ORM\Column(nullable: false)]
    private ?int $durationInMinutes = null;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $deletedAt = null;

    #[ORM\Column(nullable: true)]
    private ?string $posterName = null;

    #[ORM\Column(nullable: true)]
    private ?int $posterSize = null;

    #[ORM\OneToMany(
        mappedBy: 'movie',
        targetEntity: MovieStaff::class,
        cascade: ['all']
    )]
    private Collection $staffItems;

    #[Vich\UploadableField(mapping: 'posters', fileNameProperty: 'posterName', size: 'posterSize')]
    private ?File $poster = null;

    public function __construct()
    {
        $this->staffItems = new ArrayCollection();
    }

    public function __toString(): string
    {
        return sprintf(
            '%s (%s)',
            $this->getTitle(),
            $this->getPremieredAt() ? $this->getPremieredAt()->format('Y') : 'N'
        );
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

    public function getOriginalTitle(): ?string
    {
        return $this->originalTitle;
    }

    public function setOriginalTitle(?string $originalTitle): void
    {
        $this->originalTitle = $originalTitle;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }

    public function getPremieredAt(): ?\DateTimeInterface
    {
        return $this->premieredAt;
    }

    public function setPremieredAt(?\DateTimeInterface $premieredAt): void
    {
        $this->premieredAt = $premieredAt;
    }

    public function getCountries(): array
    {
        return $this->countries;
    }

    public function setCountries(array $countries): void
    {
        $this->countries = $countries;
    }

    public function getGenres(): array
    {
        return $this->genres;
    }

    public function setGenres(array $genres): void
    {
        $this->genres = $genres;
    }

    public function getDurationInMinutes(): ?int
    {
        return $this->durationInMinutes;
    }

    public function setDurationInMinutes(?int $durationInMinutes): void
    {
        $this->durationInMinutes = $durationInMinutes;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    public function getPosterName(): ?string
    {
        return $this->posterName;
    }

    public function setPosterName(?string $posterName): void
    {
        $this->posterName = $posterName;
    }

    public function getPosterSize(): ?int
    {
        return $this->posterSize;
    }

    public function setPosterSize(?int $posterSize): void
    {
        $this->posterSize = $posterSize;
    }

    public function getStaffItems(): Collection
    {
        return $this->staffItems;
    }

    public function setStaffItems(Collection $staffItems): void
    {
        $this->staffItems = $staffItems;
    }

    public function setPoster(?File $poster): void
    {
        $this->poster = $poster;

        if ($poster) {
            $this->setUpdatedAt(new \DateTime());
        }
    }

    public function getPoster(): ?File
    {
        return $this->poster;
    }
}
