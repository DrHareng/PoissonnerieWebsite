<?php

namespace App\Entity;

use App\Repository\PlayerGameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayerGameRepository::class)]
class PlayerGame
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'playerGames')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $_player = null;

    #[ORM\ManyToOne(inversedBy: 'playerGames')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Game $_game = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Faction $_faction = null;

    /**
     * @var Collection<int, PlayerGameResult>
     */
    #[ORM\OneToMany(targetEntity: PlayerGameResult::class, mappedBy: '_player_game')]
    private Collection $playerGameResults;

    public function __construct()
    {
        $this->playerGameResults = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayer(): ?User
    {
        return $this->_player;
    }

    public function setPlayer(?User $_player): static
    {
        $this->_player = $_player;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->_game;
    }

    public function setGame(?Game $_game): static
    {
        $this->_game = $_game;

        return $this;
    }

    public function getFaction(): ?Faction
    {
        return $this->_faction;
    }

    public function setFaction(?Faction $_faction): static
    {
        $this->_faction = $_faction;

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
            $playerGameResult->setPlayerGame($this);
        }

        return $this;
    }

    public function removePlayerGameResult(PlayerGameResult $playerGameResult): static
    {
        if ($this->playerGameResults->removeElement($playerGameResult)) {
            // set the owning side to null (unless already changed)
            if ($playerGameResult->getPlayerGame() === $this) {
                $playerGameResult->setPlayerGame(null);
            }
        }

        return $this;
    }
}
