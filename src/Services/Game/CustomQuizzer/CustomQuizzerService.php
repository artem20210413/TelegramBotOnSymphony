<?php

namespace App\Services\Game\CustomQuizzer;

use App\Entity\ActionServices;
use App\Entity\ActionUsers;
use App\Entity\CustonQuizzer;
use App\Entity\CustonQuizzerAnswer;
use App\Entity\UserPoints;
use App\Services\Telegram\Messages\MessageDto;
use App\Services\Telegram\Messages\TextMessage;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;

class CustomQuizzerService
{

    private MessageDto $messageDto;
    private TextMessage $textMessage;

    public function __construct(public EntityManagerInterface $entityManager)
    {

        /**
         * Если учавствует то результат ответа
         * Есди не учавствует чек на старт
         */

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

    public function getRandomQuestion(): array
    {
        $customQuizzer = $this->entityManager->getRepository(CustonQuizzer::class)->findAll();
        $randomIndex = rand(0, count($customQuizzer) - 1);
        $randomCustomQuizzer = $customQuizzer[$randomIndex];

        $customQuizzerAnswer = $this->entityManager->getRepository(CustonQuizzerAnswer::class)->findBy(['custom_quizzer_id' => $randomCustomQuizzer->getId()]);
        $correct = $customQuizzerAnswer[0]->getAnswer();
        shuffle($customQuizzerAnswer);


        $response = $randomCustomQuizzer->getTask() . PHP_EOL;

        foreach ($customQuizzerAnswer as $kay => $value) {
            $response .= $kay + 1 . ') ' . $value->getAnswer() . PHP_EOL;
        }
//        return [$randomCustomQuizzer, $customQuizzerAnswer];
        return ['correct' => $correct, 'textQuestion' => $response];
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

    /**
     * @return MessageDto
     */
    public function getMessageDto(): MessageDto
    {
        return $this->messageDto;
    }

    /**
     * @param MessageDto $messageDto
     */
    public function setMessageDto(MessageDto $messageDto): void
    {
        $this->messageDto = $messageDto;
    }

    /**
     * @return TextMessage
     */
    public function getTextMessage(): TextMessage
    {
        return $this->textMessage;
    }

    /**
     * @param TextMessage $textMessage
     */
    public function setTextMessage(string $message): self
    {
        $tMessage = new TextMessage();
        $tMessage->setChatId($this->messageDto->getChatId());
        $tMessage->setReplyToMessageId($this->messageDto->getMessageId());
        $tMessage->setText($message);
        $this->textMessage = $tMessage;

        return $this;
    }

    public function game(): void
    {

        $user_id = $this->messageDto->getUserDto()->getId();

        $actionServices = $this->entityManager->getRepository(ActionServices::class)->findOneBy(
            ['user_id' => $user_id, 'is_answer' => 0] // Условие WHERE: ff = 10
        );

        if ($actionServices) {
            $actionUser = $this->entityManager->getRepository(ActionUsers::class)->findOneBy(
                ['user_id' => $user_id],
                ['created_at' => 'DESC'] // Сортировка по дате создания по убыванию (от новых к старым)
            );
            if ($actionUser && (string)$actionUser->isIsCorrect() === (string)$this->messageDto->getText()) {
                $responseText = $this->getTextForMessage(true);
            } else {
                $responseText = $this->getTextForMessage(false, (string)$actionUser->isIsCorrect());
            }
        } else {

            $responseText = $this->getTextForMessage();
        }

        $this->setTextMessage($responseText ?? '');
    }

    private function getTextForMessage(bool $is_correct = null, string $correct = ''): string
    {
        if ($is_correct) {
            $headerText = 'Ответ верный!' . PHP_EOL;
            $this->addPoints($is_correct);
        } else if ($is_correct === false) {
            $headerText = 'Ответ НЕ верный!' . PHP_EOL . 'Ответ: ' . $correct . PHP_EOL;
            $this->addPoints($is_correct);
        } else {
            $headerText = '';
        }

        $randomQuestion = $this->getRandomQuestion();
        $correct = $randomQuestion['correct'] ?? '';
        $textQuestion = $randomQuestion['textQuestion'] ?? '';
        $headerText .= $textQuestion;
        $this->actionUserService($correct, $headerText);

        return $headerText;
    }


    private function addPoints(bool $is_correct): void
    {
        //TODO выкинуть в config
        $points = $is_correct ? 10 : -2;
        $entityManager = clone $this->entityManager;
        $user_id = $this->messageDto->getUserDto()->getId();
        $userPoints = $this->entityManager->getRepository(UserPoints::class)->findOneBy(
            ['user_id' => $user_id] // Условие WHERE: ff = 10
        );
        if (!$userPoints) {
            $userPoints = new UserPoints();
            $userPoints->setUserId($user_id);
            $userPoints->setPoint(max(0, $points));
            $entityManager->persist($userPoints);
        } else {
            $userPoints->setPoint(max(0, $userPoints->getPoint() + $points));
        }
        $entityManager->flush();

    }

    private function actionUserService(string $correct, string $headerText)
    {
        $entityManager = clone $this->entityManager;

        $actionServicesRepository = $entityManager->getRepository(ActionServices::class);
        $actionServices = $actionServicesRepository->findBy([
            'user_id' => $this->messageDto->getUserDto()->getId(),
            'is_answer' => 0,
        ]);
        foreach ($actionServices as $service) {
            $service->setIsAnswer(1);
            $entityManager->persist($service);
        }
        //получить все $actionServices с UserId = $this->messageDto->getUserDto()->getId() и IsAnswer = 0, после чего поле IsAnswer  заменить на 1

        $actionUsers = new ActionUsers();
        $actionUsers->setUserId($this->messageDto->getUserDto()->getId());
        $actionUsers->setIsCorrect($correct);
        $actionUsers->setCreatedAt(new \DateTimeImmutable());
        $entityManager->persist($actionUsers);

        $actionServices = new ActionServices();
        $actionServices->setUserId($this->messageDto->getUserDto()->getId());
        $actionServices->setMessage($headerText);
        $actionServices->setIsAnswer(0);
        $actionServices->setCreatedAt(new \DateTimeImmutable());
        $entityManager->persist($actionServices);

        $entityManager->flush();

    }

}