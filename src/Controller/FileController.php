<?php

namespace App\Controller;

use App\Services\Report\ReportService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FileController extends AbstractController
{
    #[Route('/api/v1/get-report/{id}', name: 'app_file')]
    public function index(int $id, ReportService $reportService): Response
    {
        return $reportService->download($id);
    }
}
