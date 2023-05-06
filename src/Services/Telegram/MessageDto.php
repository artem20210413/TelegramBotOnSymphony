<?php


namespace App\Services\Telegram;




class MessageDto
{

    private int $updateId;
    private int $messageId;
    private UserDto $userDto;
    private $date;
    private int $chatId;
    private string $text;

    public function __construct(array $message)
    {
        $this->setDto($message);
    }

    private function setDto(array $message): void
    {
        $this->validation($message);

        $this->setUpdateId($message['update_id'])
            ->setMessageId($message['message']['message_id'])
            ->setUserDto($message['message']['from'])
            ->setDate($message['message']['date'])
            ->setText($message['message']['text'])
            ->setChatId($message['message']['chat']['id']);
    }

    private function validation(array $message)
    {
        if (!isset($message['update_id'])) {
            throw new \Exception('Invalid update_id');
        }
        if (!isset($message['message'])) {
            throw new \Exception('Invalid message');
        }
        if (!isset($message['message']['message_id'])) {
            throw new \Exception('Invalid message_id');
        }
        if (!isset($message['message']['from'])) {
            throw new \Exception('Invalid from');
        }
        if (!isset($message['message']['date'])) {
            throw new \Exception('Invalid date');
        }
        if (!isset($message['message']['text'])) {
            throw new \Exception('Invalid text');
        }
        if (!isset($message['message']['chat']['id'])) {
            throw new \Exception('Invalid chat/id');
        }

    }

    /**
     * @param int $updateId
     */
    private function setUpdateId(int $updateId): static
    {
        $this->updateId = $updateId;
        return $this;
    }

    /**
     * @param int $messageId
     */
    private function setMessageId(int $messageId): static
    {
        $this->messageId = $messageId;
        return $this;
    }

    /**
     * @param UserDto $userDto
     */
    private function setUserDto(array $from): static
    {
        $this->userDto = new UserDto($from);
        return $this;
    }

    /**
     * @param mixed $date
     */
    private function setDate(mixed $date): static
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @param int $chatId
     */
    private function setChatId(int $chatId): static
    {
        $this->chatId = $chatId;

        return $this;
    }

    /**
     * @param string $text
     */
    private function setText(string $text): static
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return int
     */
    public function getUpdateId(): int
    {
        return $this->updateId;
    }

    /**
     * @return UserDto
     */
    public function getUserDto(): UserDto
    {
        return $this->userDto;
    }

    /**
     * @return int
     */
    public function getMessageId(): int
    {
        return $this->messageId;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return int
     */
    public function getChatId(): int
    {
        return $this->chatId;
    }


}
