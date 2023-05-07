<?php

namespace App\Repository;

use App\Entity\CustonQuizzerAnswer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CustonQuizzerAnswer>
 *
 * @method CustonQuizzerAnswer|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustonQuizzerAnswer|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustonQuizzerAnswer[]    findAll()
 * @method CustonQuizzerAnswer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustonQuizzerAnswerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustonQuizzerAnswer::class);
    }

    public function save(CustonQuizzerAnswer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CustonQuizzerAnswer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CustonQuizzerAnswer[] Returns an array of CustonQuizzerAnswer objects
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

//    public function findOneBySomeField($value): ?CustonQuizzerAnswer
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
