<?php

namespace App\Repository;

use App\Entity\MathQuizzes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MathQuizzes>
 *
 * @method MathQuizzes|null find($id, $lockMode = null, $lockVersion = null)
 * @method MathQuizzes|null findOneBy(array $criteria, array $orderBy = null)
 * @method MathQuizzes[]    findAll()
 * @method MathQuizzes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MathQuizzesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MathQuizzes::class);
    }

    public function save(MathQuizzes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MathQuizzes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return MathQuizzes[] Returns an array of MathQuizzes objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MathQuizzes
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
