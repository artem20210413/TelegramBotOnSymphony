<?php

namespace App\Entity;

use App\Repository\CustonQuizzerAnswerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustonQuizzerAnswerRepository::class)]
class CustonQuizzerAnswer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $custom_quizzer_id = null;

    #[ORM\Column]
    private ?bool $is_correct = null;

    #[ORM\Column(length: 255)]
    private ?string $answer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomQuizzerId(): ?int
    {
        return $this->custom_quizzer_id;
    }

    public function setCustomQuizzerId(int $custom_quizzer_id): self
    {
        $this->custom_quizzer_id = $custom_quizzer_id;

        return $this;
    }

    public function isIsCorrect(): ?bool
    {
        return $this->is_correct;
    }

    public function setIsCorrect(bool $is_correct): self
    {
        $this->is_correct = $is_correct;

        return $this;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }
}
