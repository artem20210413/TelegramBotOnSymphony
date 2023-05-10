<?php

namespace App\Repository;

use App\Entity\ActionUsers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ActionUsers>
 *
 * @method ActionUsers|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActionUsers|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActionUsers[]    findAll()
 * @method ActionUsers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActionUsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActionUsers::class);
    }

    public function save(ActionUsers $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ActionUsers $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function getCountActiveUsers(): int
    {

        $hourAgo = new \DateTime();
        $hourAgo->modify('-1 hour');

        $count = $this->createQueryBuilder('p')
            ->select('count(DISTINCT(p.user_id))')
            ->where('p.created_at > :hourAgo')
            ->setParameter('hourAgo', $hourAgo)
            ->getQuery()
            ->getSingleScalarResult();
        return $count;
    }
}
