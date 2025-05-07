<?php

namespace App\Entity;

use App\Repository\PlayerGameResultRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayerGameResultRepository::class)]
class PlayerGameResult
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'playerGameResults')]
    #[ORM\JoinColumn(nullable: false)]
    private ?GameResult $_game_result = null;

    #[ORM\ManyToOne(inversedBy: 'playerGameResults')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PlayerGame $_player_game = null;

    #[ORM\Column]
    private ?int $tournament_points = null;

    #[ORM\Column]
    private ?int $objective_points = null;

    #[ORM\Column]
    private ?int $survivor_points = null;

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

    public function getPlayerGame(): ?PlayerGame
    {
        return $this->_player_game;
    }

    public function setPlayerGame(?PlayerGame $player_game): static
    {
        $this->_player_game = $player_game;

        return $this;
    }

    public function getTournamentPoints(): ?int
    {
        return $this->tournament_points;
    }

    public function setTournamentPoints(int $tournament_points): static
    {
        $this->tournament_points = $tournament_points;

        return $this;
    }

    public function getObjectivePoints(): ?int
    {
        return $this->objective_points;
    }

    public function setObjectivePoints(int $objective_points): static
    {
        $this->objective_points = $objective_points;

        return $this;
    }

    public function getSurvivorPoints(): ?int
    {
        return $this->survivor_points;
    }

    public function setSurvivorPoints(int $survivor_points): static
    {
        $this->survivor_points = $survivor_points;

        return $this;
    }
}
