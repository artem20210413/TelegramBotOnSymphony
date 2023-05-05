<?php


namespace App\Services\Telegram;


use App\Http\Services\Game\MathQuiz\MathQuizLogic;
use App\Http\Services\Telegram\RequestParams\GetUpdateParams;
use App\Http\Services\Telegram\RequestParams\TextMessage;

class TelegramReaderService extends TelegramClient
{
    public function __construct()
    {
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
        $mathEx = new MathQuizLogic($message);
        $tMessage = new TextMessage();
        $tMessage->setChatId($message->getChatId());
        $tMessage->setReplyToMessageId($message->getMessageId());
        $tMessage->setText($mathEx->responseMessage());

        $this->respondService->sendMessages($tMessage);
    }


}
