<?php


namespace App\Services\Telegram\Messages;


class TextMessage implements IToArray
{
    private int $chatId = 0;
    private int $replyToMessageId = 0;
    private string $text = '';

    public function toArray(): array
    {
        return [
            'chat_id' => $this->getChatId(),
            'reply_to_message_id' => $this->getReplyToMessageId(),
            'text' => $this->getText(),
        ];
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return int
     */
    public function getChatId(): int
    {
        return $this->chatId;
    }

    /**
     * @param int $chatId
     */
    public function setChatId(int $chatId): self
    {
        $this->chatId = $chatId;

        return $this;
    }

    /**
     * @return int
     */
    public function getReplyToMessageId(): int
    {
        return $this->replyToMessageId;
    }

    /**
     * @param int $replyToMessageId
     */
    public function setReplyToMessageId(int $replyToMessageId): self
    {
        $this->replyToMessageId = $replyToMessageId;

        return $this;
    }


}
