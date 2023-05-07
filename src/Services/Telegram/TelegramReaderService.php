<?php


namespace App\Services\Telegram;


use App\Services\Game\MathQuiz\MathQuizLogic;
use App\Services\Telegram\Message\GetUpdateParams;
use App\Services\Telegram\Message\MessageDto;
use App\Services\Telegram\Message\TextMessage;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TelegramReaderService extends TelegramClient
{
    public TelegramRespondService $respondService;

    public function __construct(public ParameterBagInterface $parameterBag)
    {
        $this->respondService = new TelegramRespondService($parameterBag);
        parent::__construct($parameterBag);
    }

    public function getUpdates(int $offset = 0): int
    {
        $messages = $this->makeRequest(TelegramApiMethodDictionary::METHOD_GET_UPDATE, GetUpdateParams::create($offset + 1));

        if (!$messages) {
            return 0;
        }
        foreach ($messages as $message) {
            $messagesDto = new MessageDto($message);
            $this->handleMathQuizMessage($messagesDto);
        }
        return $messagesDto->getUpdateId();

    }

    private function handleMessage(MessageDto $message)
    {
        $tMessage = new TextMessage();
        $tMessage->setChatId($message->getChatId());
        $tMessage->setReplyToMessageId($message->getMessageId());
        $tMessage->setText($message->getText());

        $this->respondService->sendMessages($tMessage);
    }

    private function handleMathQuizMessage(MessageDto $message)
    {
        $mathEx = new MathQuizLogic($message, $this->parameterBag);
        $tMessage = new TextMessage();
        $tMessage->setChatId($message->getChatId());
        $tMessage->setReplyToMessageId($message->getMessageId());
        $tMessage->setText($mathEx->responseMessage());

        $this->respondService->sendMessages($tMessage);
    }


}
