<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['country:read']],
    denormalizationContext: ['groups' => ['country:write']]
)]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['country:read','country:write'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['country:read', 'country:write','visit:read'])]
    private ?string $name = null;

    /**
     * @var Collection<int, Guide>
     */
    #[ORM\OneToMany(targetEntity: Guide::class, mappedBy: 'country')]
    #[Groups(['country:read'])]
    private Collection $guides;

    /**
     * @var Collection<int, Visit>
     */
    #[ORM\OneToMany(targetEntity: Visit::class, mappedBy: 'country')]
    #[Groups(['country:read'])]
    private Collection $visits;

    public function __construct()
    {
        $this->guides = new ArrayCollection();
        $this->visits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Collection<int, Guide>
     */
    public function getGuides(): Collection
    {
        return $this->guides;
    }

    public function addGuide(Guide $guide): static
    {
        if (!$this->guides->contains($guide)) {
            $this->guides->add($guide);
            $guide->setCountry($this);
        }

        return $this;
    }

    public function removeGuide(Guide $guide): static
    {
        if ($this->guides->removeElement($guide)) {
            if ($guide->getCountry() === $this) {
                $guide->setCountry(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Visit>
     */
    public function getVisits(): Collection
    {
        return $this->visits;
    }

    public function addVisit(Visit $visit): static
    {
        if (!$this->visits->contains($visit)) {
            $this->visits->add($visit);
            $visit->setCountry($this);
        }

        return $this;
    }

    public function removeVisit(Visit $visit): static
    {
        if ($this->visits->removeElement($visit)) {
            if ($visit->getCountry() === $this) {
                $visit->setCountry(null);
            }
        }

        return $this;
    }
}

