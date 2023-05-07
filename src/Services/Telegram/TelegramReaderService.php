<?php


namespace App\Services\Telegram;


<<<<<<< HEAD
<<<<<<< HEAD
=======
use App\Services\Game\CustomQuizzer\CustomQuizzerService;
>>>>>>> parent of c731978 (Revert "bug MessageDto")
use App\Services\Game\MathQuiz\MathQuizLogic;
use App\Services\Telegram\Message\GetUpdateParams;
use App\Services\Telegram\Message\MessageDto;
use App\Services\Telegram\Message\TextMessage;
<<<<<<< HEAD
=======
use Doctrine\ORM\EntityManagerInterface;
>>>>>>> parent of c731978 (Revert "bug MessageDto")
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TelegramReaderService extends TelegramClient
{
    public TelegramRespondService $respondService;

    public function __construct(public ParameterBagInterface $parameterBag, public EntityManagerInterface $entityManager)
=======
use App\Http\Services\Game\MathQuiz\MathQuizLogic;
use App\Http\Services\Telegram\RequestParams\GetUpdateParams;
use App\Http\Services\Telegram\RequestParams\TextMessage;

class TelegramReaderService extends TelegramClient
{
    public function __construct()
>>>>>>> parent of 2e4040f (moved project in symfony)
    {
    }

    public function getUpdates(int $offset = 0): int
    {
        $messages = $this->makeRequest(TelegramApiMethodDictionary::METHOD_GET_UPDATE, GetUpdateParams::create($offset + 1));

        if (!$messages) {
            return 0;
        }

        $lastUpdateId = 0;
        foreach ($messages as $message) {
            $messageDto = new MessageDto($message);
            $this->handleCustomQuizzer($messageDto);
            $lastUpdateId = $messageDto->getUpdateId();
        }

        return $lastUpdateId;
    }

//    private function handleMessage(MessageDto $message)
//    {
//        $tMessage = new TextMessage();
//        $tMessage->setChatId($message->getChatId());
//        $tMessage->setReplyToMessageId($message->getMessageId());
//        $tMessage->setText($message->getText());
//
//        $this->respondService->sendMessages($tMessage);
//    }

    private function handleMathQuizMessage(MessageDto $message)
    {
        $mathEx = new MathQuizLogic($message);
        $tMessage = new TextMessage();
        $tMessage->setChatId($message->getChatId());
        $tMessage->setReplyToMessageId($message->getMessageId());
        $tMessage->setText($mathEx->responseMessage());

        $this->respondService->sendMessages($tMessage);
    }

    private function handleCustomQuizzer(MessageDto $message)
    {
        $customQuizzerService = new CustomQuizzerService($message, $this->entityManager);
        dd('handleCustomQuizzer');
        $tMessage = $customQuizzerService->getTextMessage();
        $this->respondService->sendMessages($tMessage);
    }


}
