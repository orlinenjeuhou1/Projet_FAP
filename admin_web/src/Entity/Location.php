<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['location:read']],
    denormalizationContext: ['groups' => ['location:write']]
)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['location:read','location:write'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['location:read', 'location:write','visit:read'])]
    private ?string $name = null;

    /**
     * @var Collection<int, Visit>
     */
    #[ORM\OneToMany(targetEntity: Visit::class, mappedBy: 'location')]
    #[Groups(['location:read'])]
    private Collection $visits;

    public function __construct()
    {
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
            $visit->setLocation($this);
        }
        return $this;
    }

    public function removeVisit(Visit $visit): static
    {
        if ($this->visits->removeElement($visit)) {
            if ($visit->getLocation() === $this) {
                $visit->setLocation(null);
            }
        }
        return $this;
    }
}

