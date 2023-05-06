<?php

namespace App\Repository;

use App\Entity\CustomQuizzerAnswer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CustomQuizzerAnswer>
 *
 * @method CustomQuizzerAnswer|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomQuizzerAnswer|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomQuizzerAnswer[]    findAll()
 * @method CustomQuizzerAnswer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomQuizzerAnswerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomQuizzerAnswer::class);
    }

    public function save(CustomQuizzerAnswer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CustomQuizzerAnswer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CustomQuizzerAnswer[] Returns an array of CustomQuizzerAnswer objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CustomQuizzerAnswer
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
