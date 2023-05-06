<?php

namespace App\Repository;

use App\Entity\CustomQuizzer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CustomQuizzer>
 *
 * @method CustomQuizzer|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomQuizzer|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomQuizzer[]    findAll()
 * @method CustomQuizzer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomQuizzerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomQuizzer::class);
    }

    public function save(CustomQuizzer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CustomQuizzer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CustomQuizzer[] Returns an array of CustomQuizzer objects
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

//    public function findOneBySomeField($value): ?CustomQuizzer
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
