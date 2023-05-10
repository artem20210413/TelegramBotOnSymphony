<?php

namespace App\Repository;

use App\Entity\Report;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Report>
 *
 * @method Report|null find($id, $lockMode = null, $lockVersion = null)
 * @method Report|null findOneBy(array $criteria, array $orderBy = null)
 * @method Report[]    findAll()
 * @method Report[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Report::class);
    }

    public function save(Report $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Report $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function reportCompleted(int $id, string $data): void
    {
        $entityManager = $this->getEntityManager();
        $report = $this->find($id);

        if (!$report) {
            throw $this->createNotFoundException('Record with specified id not found.');
        }

        $report->setIsProcessed(1);
        $report->setReportMessage($data);

        $entityManager->flush();
    }


    public function getDataById(int $id): array
    {
        $report = $this->find($id);
        $dataString = $report->getReportMessage();
        return unserialize($dataString);
    }

    public function getStatus(int $id): string
    {
        $report = $this->find($id);
        return isset($report) ? $report->isIsProcessed() ? 'ready' : 'not ready' : 'not found';
    }
}
