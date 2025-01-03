<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player
{
    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    private ?int $id;

    #[ORM\OneToMany(mappedBy: 'player', targetEntity: GameResult::class)]
    private $gameResults;

    #[ORM\Column(type: 'string', length: 255)]
    private string $nickname;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $registeredAt;

    #[ORM\Column]
    private int $honorPoints = 0;

    public function __construct(string $nickname)
    {
        $this->nickname = $nickname;
        $this->registeredAt = new \DateTimeImmutable();
        $this->gameResults = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function getRegisteredAt(): \DateTimeImmutable
    {
        return $this->registeredAt;
    }

    public function addHonorPoints(int $earnedPoints)
    {
        $this->honorPoints += $earnedPoints;
    }

    public function getHonorPoints(): int
    {
        return $this->honorPoints;
    }
}
