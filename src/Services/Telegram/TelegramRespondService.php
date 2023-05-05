<?php


namespace App\Services\Telegram;


use App\Http\Services\Telegram\RequestParams\GetUpdateParams;
use App\Http\Services\Telegram\RequestParams\TextMessage;

class TelegramRespondService extends TelegramClient
{
    public function sendMessages(TextMessage $message)
    {
        $this->makeRequest(TelegramApiMethodDictionary::METHOD_SEND_MESSAGE, $message);
    }

}
