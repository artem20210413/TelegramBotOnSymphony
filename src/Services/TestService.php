<?php

namespace App\Services;

use App\Entity\CustomQuizzer;
use App\Entity\CustomQuizzerAnswer;
use App\Repository\CustomQuizzerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TestService
{

    public function __construct(public ParameterBagInterface $parameterBag, EntityManagerInterface $entityManager)
    {



        dd('end...');
        $this->saveNewQuiz($entityManager, '1*8', 8, 12, 16, 1);

        $customQuizzer = new CustomQuizzer();
        $customQuizzer->setTask('2*6');
        $entityManager->persist($customQuizzer);
        $entityManager->flush();

        dd('Saved new customQuizzer with id ' . $customQuizzer->getId());
    }

    public function test()
    {

        $customQuizzer = new CustomQuizzer();
        $customQuizzer->setTask('8*6');
        $this->entityManager->persist($customQuizzer);
        $this->entityManager->flush();

        dd('Saved new customQuizzer with id ' . $customQuizzer->getId());


//        dd($this->cache->get('telegram'), $this->cache->parameterBag->get('telegram'));
//        $ff = $this->parameterBag->get('telegram')['token'];
        dd($this->parameterBag->get('telegram')['TELEGRAM_DOMAIN'], $this->parameterBag->get('telegram')['TELEGRAM_TOKEN']);
    }

    public function saveNewQuiz(EntityManagerInterface $entityManager, string $task, mixed ...$answers)
    {
        $customQuizzer = new CustomQuizzer();
        $customQuizzer->setTask($task);

        $entityManager->persist($customQuizzer);
        $entityManager->flush();


        foreach ($answers as $key => $answer) {
            $customQuizzerAnswer = new CustomQuizzerAnswer();
            $customQuizzerAnswer->setCustomQuizzerId($customQuizzer->getId());
            $customQuizzerAnswer->setAnswer($answer);
            $customQuizzerAnswer->setIsCorrect($key === 0);
            $entityManager->persist($customQuizzerAnswer);
        }
        $entityManager->flush();

        dd('successful');
    }

}