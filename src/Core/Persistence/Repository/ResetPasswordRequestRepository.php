<?php

namespace App\Core\Persistence\Repository;

use App\Core\Persistence\Entity\ResetPasswordRequest;
use App\Core\Persistence\Entity\User;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestInterface;
use SymfonyCasts\Bundle\ResetPassword\Persistence\Repository\ResetPasswordRequestRepositoryTrait;
use SymfonyCasts\Bundle\ResetPassword\Persistence\ResetPasswordRequestRepositoryInterface;

/**
 * @extends ServiceEntityRepository<ResetPasswordRequest>
 *
 * @method ResetPasswordRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResetPasswordRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResetPasswordRequest[]    findAll()
 * @method ResetPasswordRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResetPasswordRequestRepository extends ServiceEntityRepository implements ResetPasswordRequestRepositoryInterface
{
    use ResetPasswordRequestRepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResetPasswordRequest::class);
    }

    /**
     * @param User|object $user
     * @param DateTimeInterface $expiresAt
     * @param string $selector
     * @param string $hashedToken
     * @return ResetPasswordRequestInterface
     */
    public function createResetPasswordRequest(
        object $user,
        DateTimeInterface $expiresAt,
        string $selector,
        string $hashedToken
    ): ResetPasswordRequestInterface {
        return new ResetPasswordRequest(
            $user,
            $expiresAt,
            $selector,
            $hashedToken
        );
    }

    public function save(ResetPasswordRequest $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
