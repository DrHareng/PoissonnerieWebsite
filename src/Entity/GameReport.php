<?php

namespace App\Entity;

use App\Repository\GameReportRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameReportRepository::class)]
class GameReport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'gameReports')]
    #[ORM\JoinColumn(nullable: false)]
    private ?GameResult $_game_result = null;

    #[ORM\ManyToOne(inversedBy: 'gameReports')]
    private ?User $_author = null;

    #[ORM\Column(length: 255)]
    private ?string $phase = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGameResult(): ?GameResult
    {
        return $this->_game_result;
    }

    public function setGameResult(?GameResult $_game_result): static
    {
        $this->_game_result = $_game_result;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->_author;
    }

    public function setAuthor(?User $_author): static
    {
        $this->_author = $_author;

        return $this;
    }

    public function getPhase(): ?string
    {
        return $this->phase;
    }

    public function setPhase(?string $phase): static
    {
        $this->phase = $phase;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }
}
