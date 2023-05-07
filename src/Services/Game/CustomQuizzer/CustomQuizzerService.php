<?php

namespace App\Services\Game\CustomQuizzer;

use App\Entity\CustonQuizzer;
use App\Entity\CustonQuizzerAnswer;
use Doctrine\ORM\EntityManagerInterface;

class CustomQuizzerService
{
    public function __construct(public EntityManagerInterface $entityManager)
    {
    }

    public function createQuestion(array $data): bool
    {
        $task = $data['task'] ?? null;
        $answer = $data['answer'] ?? null;

        if ($task && $answer) {
            $this->saveNewQuiz($this->entityManager, $task, $answer);

            return true;
        }

        return false;
    }

    public function getRandomQuestion(EntityManagerInterface $entityManager): array
    {
        $customQuizzer = $entityManager->getRepository(CustonQuizzer::class)->findAll();
        $randomIndex = rand(0, count($customQuizzer) - 1);
        $randomCustomQuizzer = $customQuizzer[$randomIndex];

        $customQuizzerAnswer = $entityManager->getRepository(CustonQuizzerAnswer::class)->findBy(['custom_quizzer_id' => $randomCustomQuizzer->getId()]);
        shuffle($customQuizzerAnswer);

        return [$randomCustomQuizzer, $customQuizzerAnswer];
    }

    public function saveNewQuiz(EntityManagerInterface $entityManager, string $task, array $answers)
    {
        $customQuizzer = new CustonQuizzer();
        $customQuizzer->setTask($task);

        $entityManager->persist($customQuizzer);
        $entityManager->flush();


        foreach ($answers as $key => $answer) {
            $customQuizzerAnswer = new CustonQuizzerAnswer();
            $customQuizzerAnswer->setCustomQuizzerId($customQuizzer->getId());
            $customQuizzerAnswer->setAnswer($answer);
            $customQuizzerAnswer->setIsCorrect($key === 0);
            $entityManager->persist($customQuizzerAnswer);
        }
        $entityManager->flush();
    }


}