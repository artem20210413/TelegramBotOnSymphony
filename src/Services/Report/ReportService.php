<?php

namespace App\Services\Report;

use App\Entity\ActionUsers;
use App\Entity\CustonQuizzerAnswer;
use App\Entity\Report;
use App\Repository\ActionUsersRepository;
use Doctrine\ORM\EntityManagerInterface;

class ReportService
{
    public function __construct(public EntityManagerInterface $entityManager, public ActionUsersRepository $actionUsersRepository)
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

        return $report->getId();
    }


    public function generationReport(Report $report)
    {
        /**
         * кількість активних користувачів/чатів - погодинно
         * процент правильних відповідей - погодинно
         * процент незакінчених квізів(умова відправлена, але немає правильної відповіді) - за весь час
         * Загальна кількість ропочатих квізів
         * Загальна кількість унікальних користувачів*/

        $countActiveUsers = $this->actionUsersRepository->getCountActiveUsers();
        $percentageCorrectAnswers = $this->calculationPercentageCorrectAnswers();
        $percentageIncorrectAnswers = $this->calculationPercentageIncorrectAnswers();
        $totalCountQuizzesStarted = $this->calculationTotalCountQuizzesStarted();
        $totalCountUniqueUsers = $this->calculationTotalCountUniqueUsers();


    }


}