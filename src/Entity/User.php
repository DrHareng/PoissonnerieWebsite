<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
class User implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $username = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $discordId = null;

    #[ORM\Column(length: 180, unique: true, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $avatar = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $displayname = null;

    /**
     * @var Collection<int, GameReport>
     */
    #[ORM\OneToMany(targetEntity: GameReport::class, mappedBy: '_author')]
    private Collection $gameReports;

    /**
     * @var Collection<int, PlayerGame>
     */
    #[ORM\OneToMany(targetEntity: PlayerGame::class, mappedBy: '_player')]
    private Collection $playerGames;

    public function __construct()
    {
        $this->gameReports = new ArrayCollection();
        $this->playerGames = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getDiscordId(): ?string
    {
        return $this->discordId;
    }

    public function setDiscordId(?string $discordId): static
    {
        $this->discordId = $discordId;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): static
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getDisplayname(): ?string
    {
        return $this->displayname;
    }

    public function setDisplayname(?string $displayname): static
    {
        $this->displayname = $displayname;

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
            $gameReport->setAuthor($this);
        }

        return $this;
    }

    public function removeGameReport(GameReport $gameReport): static
    {
        if ($this->gameReports->removeElement($gameReport)) {
            // set the owning side to null (unless already changed)
            if ($gameReport->getAuthor() === $this) {
                $gameReport->setAuthor(null);
            }
        }

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
            $playerGame->setPlayer($this);
        }

        return $this;
    }

    public function removePlayerGame(PlayerGame $playerGame): static
    {
        if ($this->playerGames->removeElement($playerGame)) {
            // set the owning side to null (unless already changed)
            if ($playerGame->getPlayer() === $this) {
                $playerGame->setPlayer(null);
            }
        }

        return $this;
    }

    public function __toString(){
        return ($this->getDisplayname() != null ? $this->getDisplayname() : $this->getUsername());
    }
}
