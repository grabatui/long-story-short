<?php

namespace App\Core\Persistence\Repository;

use App\Core\Persistence\Entity\MovieStaff;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MovieStaff>
 *
 * @method MovieStaff|null find($id, $lockMode = null, $lockVersion = null)
 * @method MovieStaff|null findOneBy(array $criteria, array $orderBy = null)
 * @method MovieStaff[]    findAll()
 * @method MovieStaff[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieStaffRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MovieStaff::class);
    }

    public function remove(MovieStaff $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
