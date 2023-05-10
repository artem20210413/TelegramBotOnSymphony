<?php

namespace App\Entity;

use App\Repository\MathQuizzesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MathQuizzesRepository::class)]
class MathQuizzes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $user_telegram_id = null;

    #[ORM\Column]
    private ?int $active_result = null;

    #[ORM\Column]
    private ?int $score = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_created = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserTelegramId(): ?int
    {
        return $this->user_telegram_id;
    }

    public function setUserTelegramId(int $user_telegram_id): self
    {
        $this->user_telegram_id = $user_telegram_id;

        return $this;
    }

    public function getActiveResult(): ?int
    {
        return $this->active_result;
    }

    public function setActiveResult(int $active_result): self
    {
        $this->active_result = $active_result;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->date_created;
    }

    public function setDateCreated(\DateTimeInterface $date_created): self
    {
        $this->date_created = $date_created;

        return $this;
    }
}
