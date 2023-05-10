<?php

namespace App\Controller;

use App\Services\Game\CustomQuizzer\CustomQuizzerService;
use App\Services\Report\ReportService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportController extends AbstractController
{
    #[Route('/api/v1/create/report', name: 'create_report', methods: 'POST')]
    public function index(ReportService $reportService): Response
    {
        $reportId = $reportService->createReport();
        return $this->json(['ReportId' => $reportId]);
    }
}