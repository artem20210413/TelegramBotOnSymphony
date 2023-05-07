<?php


namespace App\Services\Telegram;


<<<<<<< HEAD
use App\Services\Telegram\Message\TextMessage;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
=======
use App\Http\Services\Telegram\RequestParams\GetUpdateParams;
use App\Http\Services\Telegram\RequestParams\TextMessage;
>>>>>>> parent of 2e4040f (moved project in symfony)

class TelegramRespondService extends TelegramClient
{
    public function sendMessages(TextMessage $message)
    {
        $this->makeRequest(TelegramApiMethodDictionary::METHOD_SEND_MESSAGE, $message);
    }

}
