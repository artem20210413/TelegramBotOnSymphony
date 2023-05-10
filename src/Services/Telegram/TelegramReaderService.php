<?php


namespace App\Services\Telegram;


use App\Services\Game\CustomQuizzer\CustomQuizzerService;
use App\Services\Telegram\Messages\GetUpdateParams;
use App\Services\Telegram\Messages\MessageDto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TelegramReaderService extends TelegramClient
{
    public TelegramRespondService $respondService;

    public function __construct(public ParameterBagInterface $parameterBag, public EntityManagerInterface $entityManager)
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
            $this->handleCustomQuizzer($messagesDto);
            $countUSerId = $messagesDto->getUpdateId();
        }
        return $countUSerId ?? 0;
    }

    private function handleCustomQuizzer(MessageDto $message)
    {
        $customQuizzerService = new CustomQuizzerService($this->entityManager);
        $customQuizzerService->setMessageDto($message);
        $customQuizzerService->core();
        $tMessage = $customQuizzerService->getTextMessage();
        $this->respondService->sendMessages($tMessage);
    }


}
