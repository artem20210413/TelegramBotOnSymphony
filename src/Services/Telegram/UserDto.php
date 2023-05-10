<?php


namespace App\Services\Telegram;


use http\Exception\InvalidArgumentException;
use mysql_xdevapi\SqlStatementResult;

class UserDto
{
    private int $id;
    private bool $isBot;
    private string $firstName;
    private string $lastName;
    private string $username;
    private string $isPremium;

    public function __construct(array $from)
    {
        $this->setThisDto($from);
    }

    private function setThisDto(array $from): UserDto
    {
        $this->validation($from);

        return $this->setId($from['id'])
            ->setIsBot($from['is_bot'])
            ->setFirstName($from['first_name'])
            ->setLastName($from['last_name'])
            ->setUsername($from['username'])
            ->setIsPremium($from['is_premium']);
    }

    private function validation(array $from)
    {

        if (!isset($from['id'])) {
            throw new InvalidArgumentException('Invalid from/id');
        }
        if (!isset($from['is_bot'])) {
            throw new InvalidArgumentException('Invalid from/is_bot');
        }
        if (!isset($from['first_name'])) {
            throw new InvalidArgumentException('Invalid from/first_name');
        }
        if (!isset($from['last_name'])) {
            throw new InvalidArgumentException('Invalid from/last_name');
        }
        if (!isset($from['username'])) {
            throw new InvalidArgumentException('Invalid from/username');
        }
        if (!isset($from['is_premium'])) {
            throw new InvalidArgumentException('Invalid from/is_premium');
        }

    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isBot(): bool
    {
        return $this->isBot;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }


    /**
     * @return string
     */
    public function getIsPremium(): string
    {
        return $this->isPremium;
    }

    /**
     * @param int $id
     * @return UserDto
     */
    public function setId(int $id): UserDto
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param bool $isBot
     * @return UserDto
     */
    public function setIsBot(bool $isBot): UserDto
    {
        $this->isBot = $isBot;
        return $this;
    }

    /**
     * @param string $lastName
     * @return UserDto
     */
    public function setLastName(string $lastName): UserDto
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @param string $username
     * @return UserDto
     */
    public function setUsername(string $username): UserDto
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @param string $isPremium
     * @return UserDto
     */
    public function setIsPremium(string $isPremium): UserDto
    {
        $this->isPremium = $isPremium;
        return $this;
    }

    /**
     * @param string $firstName
     * @return UserDto
     */
    public function setFirstName(string $firstName): UserDto
    {
        $this->firstName = $firstName;
        return $this;
    }

}
