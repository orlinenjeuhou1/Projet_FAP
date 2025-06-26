<?php

namespace App\Entity;

use App\Repository\TouristRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TouristRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['tourist:read']],
    denormalizationContext: ['groups' => ['tourist:write']]
)]
class Tourist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['tourist:read', 'visit_tourist:read', 'visit:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['tourist:read', 'tourist:write', 'visit_tourist:read', 'visit:read'])]
    private ?string $firstname = null;

    #[ORM\Column(length: 100)]
    #[Groups(['tourist:read', 'tourist:write', 'visit_tourist:read', 'visit:read'])]
    private ?string $lastname = null;

    #[ORM\Column]
    #[Groups(['tourist:read', 'visit_tourist:read', 'visit:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['tourist:read', 'visit_tourist:read', 'visit:read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, VisitTourist>
     */
    #[ORM\OneToMany(targetEntity: VisitTourist::class, mappedBy: 'tourist')]
    #[Groups(['tourist:read'])]
    private Collection $visitTourists;

    public function __construct()
    {
        $this->visitTourists = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }
    public function getFirstname(): ?string { return $this->firstname; }
    public function setFirstname(string $firstname): static { $this->firstname = $firstname; return $this; }
    public function getLastname(): ?string { return $this->lastname; }
    public function setLastname(string $lastname): static { $this->lastname = $lastname; return $this; }
    public function getCreatedAt(): ?\DateTimeImmutable { return $this->createdAt; }
    public function setCreatedAt(\DateTimeImmutable $createdAt): static { $this->createdAt = $createdAt; return $this; }
    public function getUpdatedAt(): ?\DateTimeImmutable { return $this->updatedAt; }
    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static { $this->updatedAt = $updatedAt; return $this; }

    /**
     * @return Collection<int, VisitTourist>
     */
    public function getVisitTourists(): Collection
    {
        return $this->visitTourists;
    }

    public function addVisitTourist(VisitTourist $visitTourist): static
    {
        if (!$this->visitTourists->contains($visitTourist)) {
            $this->visitTourists->add($visitTourist);
            $visitTourist->setTourist($this);
        }

        return $this;
    }

    public function removeVisitTourist(VisitTourist $visitTourist): static
    {
        if ($this->visitTourists->removeElement($visitTourist)) {
            if ($visitTourist->getTourist() === $this) {
                $visitTourist->setTourist(null);
            }
        }

        return $this;
    }
}

