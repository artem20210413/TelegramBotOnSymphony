<?php


namespace App\Services\Telegram;


use App\Services\Telegram\Message\TextMessage;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TelegramRespondService extends TelegramClient
{

    public function __construct(public ParameterBagInterface $parameterBag)
    {
        parent::__construct($parameterBag);
    }
    public function sendMessages(TextMessage $message)
    {
        $this->makeRequest(TelegramApiMethodDictionary::METHOD_SEND_MESSAGE, $message);
    }

}
