<?php

namespace App\Repository;

use App\Entity\ActionServices;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ActionServices>
 *
 * @method ActionServices|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActionServices|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActionServices[]    findAll()
 * @method ActionServices[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActionServicesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActionServices::class);
    }

    public function save(ActionServices $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ActionServices $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getCorrectAnswers(): int
    {
        $countCorrect = $this->createQueryBuilder('p')
            ->select('count(p.user_id)')
            ->where("p.message LIKE '%Ответ верный!%'")
            ->getQuery()
            ->getSingleScalarResult();
        return $countCorrect;

    }


    public function getAllAnswers(): int
    {
        $countCorrect = $this->createQueryBuilder('p')
            ->select('count(p.user_id)')
            ->getQuery()
            ->getSingleScalarResult();
        return $countCorrect;
    }


    public function getInCorrectAnswers(): int
    {
        $countCorrect = $this->createQueryBuilder('p')
            ->select('count(p.user_id)')
            ->where("p.message LIKE '%Ответ НЕ верный!%'")
            ->getQuery()
            ->getSingleScalarResult();
        return $countCorrect;
    }
}
