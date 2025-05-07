<?php

namespace App\Entity;

use App\Repository\GameResultRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameResultRepository::class)]
class GameResult
{
    const STATUS_WAITING_RESULT = 'A jouer';
    const STATUS_WAITING_VALIDATION = 'A valider';
    const STATUS_VALIDATED = 'Terminée';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $registered_by = null;

    #[ORM\ManyToOne]
    private ?User $validated_by = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    /**
     * @var Collection<int, PlayerGameResult>
     */
    #[ORM\OneToMany(targetEntity: PlayerGameResult::class, mappedBy: '_game_result', orphanRemoval: true, cascade: ['persist'])]
    private Collection $playerGameResults;

    /**
     * @var Collection<int, GameReport>
     */
    #[ORM\OneToMany(targetEntity: GameReport::class, mappedBy: '_game_result')]
    private Collection $gameReports;

    #[ORM\OneToOne(inversedBy: 'gameResult', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Game $_game = null;

    private ?PlayerGameResult $player1Result = null;
    private ?PlayerGameResult $player2Result = null;

    public function __construct()
    {
        $this->playerGameResults = new ArrayCollection();
        $this->gameReports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getRegisteredBy(): ?User
    {
        return $this->registered_by;
    }

    public function setRegisteredBy(?User $registered_by): static
    {
        $this->registered_by = $registered_by;

        return $this;
    }

    public function getValidatedBy(): ?User
    {
        return $this->validated_by;
    }

    public function setValidatedBy(?User $validated_by): static
    {
        $this->validated_by = $validated_by;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, PlayerGameResult>
     */
    public function getPlayerGameResults(): Collection
    {
        return $this->playerGameResults;
    }

    public function addPlayerGameResult(PlayerGameResult $playerGameResult): static
    {
        if (!$this->playerGameResults->contains($playerGameResult)) {
            $this->playerGameResults->add($playerGameResult);
            $playerGameResult->setGameResult($this);
        }

        return $this;
    }

    public function removePlayerGameResult(PlayerGameResult $playerGameResult): static
    {
        if ($this->playerGameResults->removeElement($playerGameResult)) {
            // set the owning side to null (unless already changed)
            if ($playerGameResult->getGameResult() === $this) {
                $playerGameResult->setGameResult(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, GameReport>
     */
    public function getGameReports(): Collection
    {
        return $this->gameReports;
    }

    public function addGameReport(GameReport $gameReport): static
    {
        if (!$this->gameReports->contains($gameReport)) {
            $this->gameReports->add($gameReport);
            $gameReport->setGameResult($this);
        }

        return $this;
    }

    public function removeGameReport(GameReport $gameReport): static
    {
        if ($this->gameReports->removeElement($gameReport)) {
            // set the owning side to null (unless already changed)
            if ($gameReport->getGameResult() === $this) {
                $gameReport->setGameResult(null);
            }
        }

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->_game;
    }

    public function setGame(Game $_game): static
    {
        $this->_game = $_game;

        return $this;
    }

    /**
     * Get the value of player1Result
     */ 
    public function getPlayer1Result()
    {
        return $this->player1Result;
    }

    /**
     * Set the value of player1Result
     *
     * @return  self
     */ 
    public function setPlayer1Result($player1Result)
    {
        $this->player1Result = $player1Result;

        return $this;
    }

    /**
     * Get the value of player2Result
     */ 
    public function getPlayer2Result()
    {
        return $this->player2Result;
    }

    /**
     * Set the value of player2Result
     *
     * @return  self
     */ 
    public function setPlayer2Result($player2Result)
    {
        $this->player2Result = $player2Result;

        return $this;
    }
}
