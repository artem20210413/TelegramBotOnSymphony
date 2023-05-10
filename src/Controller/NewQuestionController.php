<?php

namespace App\Controller;

use App\Services\Game\CustomQuizzer\CustomQuizzerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewQuestionController extends AbstractController
{
    /**
     * @param Request {
     * "task": "5*5",
     * "answer": ["25","30","-50"]
     * @param CustomQuizzerService $customQuizzerService
     * @return Response
     */
    #[Route('/api/v1/new/question', name: 'app_new_question', methods: 'POST')]
    public function index(Request $request, CustomQuizzerService $customQuizzerService): Response
    {
        $data = json_decode($request->getContent(), true);
        $success = $customQuizzerService->createQuestion($data);
        return $this->json(['successful' => $success]);
    }
}
