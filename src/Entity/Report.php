<?php

namespace App\Entity;

use App\Repository\ReportRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReportRepository::class)]
class Report
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $report_message = null;

    #[ORM\Column]
    private ?bool $is_processed = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReportMessage(): ?string
    {
        return $this->report_message;
    }

    public function setReportMessage(?string $report_message): self
    {
        $this->report_message = $report_message;

        return $this;
    }

    public function isIsProcessed(): ?bool
    {
        return $this->is_processed;
    }

    public function setIsProcessed(bool $is_processed): self
    {
        $this->is_processed = $is_processed;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function currentCreatedAt(): self
    {
        $this->created_at = new \DateTimeImmutable();
        return $this;
    }
}
