<?php

namespace App\EventListener\Doctrine;

use App\Core\Persistence\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[AsEntityListener(event: Events::prePersist, entity: Movie::class)]
class MovieSlugEventListener
{
    public function __invoke(Movie $entity, LifecycleEventArgs $arguments): void
    {
        $slugger = new AsciiSlugger('en');

        $slug = $slugger->slug(
            implode(' ', [
                $entity->getOriginalTitle() ?: $entity->getTitle(),
                $entity->getPremieredAt() ? $entity->getPremieredAt()->format('Y') : '',
            ])
        );

        $entity->setSlug($slug);
    }
}
