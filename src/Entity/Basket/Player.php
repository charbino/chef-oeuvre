<?php

namespace App\Entity\Basket;

use App\Repository\Basket\PlayerRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
#[ORM\Table(name: 'basket_player')]
class Player
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['basket'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['basket'])]
    private ?int $externalId = null;

    #[ORM\Column(length: 255)]
    #[Groups(['basket'])]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    #[Groups(['basket'])]
    private ?string $lastName = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['basket'])]
    private ?int $height = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['basket'])]
    private ?float $weight = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['basket'])]
    private ?string $position = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['basket'])]
    private ?string $country = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['basket'])]
    private ?int $draftNumber = null;

    #[ManyToOne(targetEntity: Team::class)]
    #[JoinColumn(name: 'team_id', referencedColumnName: 'id')]
    #[Ignore]
    #[Groups(['basket'])]
    private ?Team $team = null;

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExternalId(): ?int
    {
        return $this->externalId;
    }

    public function setExternalId(?int $externalId): self
    {
        $this->externalId = $externalId;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(?int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(?float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(?string $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): void
    {
        $this->country = $country;
    }

    public function getDraftNumber(): ?int
    {
        return $this->draftNumber;
    }

    public function setDraftNumber(?int $draftNumber): void
    {
        $this->draftNumber = $draftNumber;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): void
    {
        $this->team = $team;
    }
}
