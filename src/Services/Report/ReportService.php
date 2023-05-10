<?php

namespace App\Services\Report;

use App\Entity\ActionUsers;
use App\Entity\CustonQuizzerAnswer;
use App\Entity\Report;
use App\Services\File\File;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ActionServicesRepository;
use App\Repository\ActionUsersRepository;
use App\Repository\ReportRepository;
use App\Repository\UserPointsRepository;
use App\Services\File\CsvService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ReportService
{
    public function __construct(public EntityManagerInterface   $entityManager,
                                public ActionUsersRepository    $actionUsersRepository,
                                public ActionServicesRepository $actionServicesRepository,
                                public UserPointsRepository     $userPointsRepository,
                                public ReportRepository         $reportRepository,
                                public SerializerInterface      $serializer,
                                public File                     $file)
    {
    }

    public function createReport(): int
    {
        $entityManager = clone $this->entityManager;
        $report = new Report();
        $report->currentCreatedAt();
        $report->setIsProcessed(false);
        $entityManager->persist($report);
        $entityManager->flush();

        $this->generationReport($report);
        $this->download($report->getId()); //TODO вынести в отдельную апи
        return $report->getId();
    }


    public function generationReport(Report $report)
    {
        $reportDto = new ReportDto();
        $reportDto->setCountActiveUsers($this->actionUsersRepository->getCountActiveUsers());
        $reportDto->setPercentageCorrectAnswers($this->getPercentageCorrectAnswers());
        $reportDto->setPercentageIncorrectAnswers($this->getPercentageIncorrectAnswers());
        $reportDto->setTotalCountQuizzesStarted($this->actionServicesRepository->getAllAnswers());
        $reportDto->setTotalCountUniqueUsers($this->userPointsRepository->countUsers());

        $file = new CsvService($reportDto);
        $data = $file->getData();
        $this->reportRepository->reportCompleted($report->getId(), $data);
        return $file->generateAndSaveCsvFile($this->serializer);

    }

    private function getPercentageCorrectAnswers(): float
    {
        $countAll = $this->actionServicesRepository->getAllAnswers();
        $countCorrect = $this->actionServicesRepository->getCorrectAnswers();
        return round(($countCorrect * 100 / $countAll), 2);

    }

    private function getPercentageIncorrectAnswers(): float
    {
        $countAll = $this->actionServicesRepository->getAllAnswers();
        $countIncorrect = $this->actionServicesRepository->getInCorrectAnswers();

        return round(($countIncorrect * 100 / $countAll), 2);
    }

    public function download(int $id): Response //TODO создать API
    {

        $data = $this->reportRepository->getDataById($id);
        return $this->file->download($data, $this->serializer);
    }


    public function getStatus(int $id): string
    {
        return $this->reportRepository->getStatus($id);
    }

}