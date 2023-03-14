<?php

namespace App\Core\Persistence\Repository;

use App\Core\Persistence\Entity\MovieRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MovieRequest>
 *
 * @method MovieRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method MovieRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method MovieRequest[]    findAll()
 * @method MovieRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MovieRequest::class);
    }

    public function save(MovieRequest $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MovieRequest $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
