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

    #[Route('/api/v1/get/report/status/{id}', name: 'create_report', methods: 'GET')]
    public function status(int $id, ReportService $reportService): Response
    {
        $status = $reportService->getStatus($id);
        return $this->json(['status' => $status]);
    }


}