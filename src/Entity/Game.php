<?php

namespace App\Entity;

use App\Repository\GameRepository;
use App\Validator\GameHasDifferentPlayers;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[GameHasDifferentPlayers]
#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(mappedBy: '_game', cascade: ['persist', 'remove'])]
    private ?GameResult $gameResult = null;

    #[ORM\ManyToOne(inversedBy: 'games')]
    private ?Scenario $_scenario = null;

    /**
     * @var Collection<int, PlayerGame>
     */
    #[ORM\OneToMany(targetEntity: PlayerGame::class, mappedBy: '_game', cascade: ['persist'])]
    private Collection $playerGames;

    private ?PlayerGame $player1 = null;
    private ?PlayerGame $player2 = null;

    public function __construct()
    {
        $this->playerGames = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGameResult(): ?GameResult
    {
        return $this->gameResult;
    }

    public function setGameResult(GameResult $gameResult): static
    {
        // set the owning side of the relation if necessary
        if ($gameResult->getGame() !== $this) {
            $gameResult->setGame($this);
        }

        $this->gameResult = $gameResult;

        return $this;
    }

    public function getScenario(): ?Scenario
    {
        return $this->_scenario;
    }

    public function setScenario(?Scenario $_scenario): static
    {
        $this->_scenario = $_scenario;

        return $this;
    }

    /**
     * @return Collection<int, PlayerGame>
     */
    public function getPlayerGames(): Collection
    {
        return $this->playerGames;
    }

    public function addPlayerGame(PlayerGame $playerGame): static
    {
        if (!$this->playerGames->contains($playerGame)) {
            $this->playerGames->add($playerGame);
            $playerGame->setGame($this);
        }

        return $this;
    }

    public function removePlayerGame(PlayerGame $playerGame): static
    {
        if ($this->playerGames->removeElement($playerGame)) {
            // set the owning side to null (unless already changed)
            if ($playerGame->getGame() === $this) {
                $playerGame->setGame(null);
            }
        }

        return $this;
    }

    /**
     * Get the value of player1
     */ 
    public function getPlayer1()
    {
        return $this->player1;
    }

    /**
     * Set the value of player1
     *
     * @return  self
     */ 
    public function setPlayer1($player1)
    {
        $this->player1 = $player1;

        return $this;
    }

    /**
     * Get the value of player2
     */ 
    public function getPlayer2()
    {
        return $this->player2;
    }

    /**
     * Set the value of player2
     *
     * @return  self
     */ 
    public function setPlayer2($player2)
    {
        $this->player2 = $player2;

        return $this;
    }
}
