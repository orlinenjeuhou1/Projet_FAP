<?php

namespace App\Entity;

use App\Repository\GuideRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GuideRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['guide:read']],
    denormalizationContext: ['groups' => ['guide:write']]
)]
class Guide
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['guide:read','guide:write', 'visit:read', 'visit:write'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['guide:read', 'guide:write', 'visit:read'])]
    private ?string $firstname = null;

    #[ORM\Column(length: 100)]
    #[Groups(['guide:read', 'guide:write', 'visit:read'])]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['guide:read', 'guide:write'])]
    private ?string $photo = null;

    #[ORM\Column(length: 20)]
    #[Groups(['guide:read', 'guide:write'])]
    private ?string $status = null;

    #[ORM\Column]
    #[Groups(['guide:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['guide:read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'guides')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['guide:read', 'guide:write'])]
    private ?User $appUser = null;

    #[ORM\ManyToOne(inversedBy: 'guides')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['guide:read', 'guide:write'])]
    private ?Country $country = null;

    #[ORM\OneToMany(targetEntity: Visit::class, mappedBy: 'guide')]
    private Collection $visits;

    public function __construct()
    {
        $this->visits = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    // Getters & setters...

    public function getId(): ?int { return $this->id; }
    public function getFirstname(): ?string { return $this->firstname; }
    public function setFirstname(string $firstname): static { $this->firstname = $firstname; return $this; }
    public function getLastname(): ?string { return $this->lastname; }
    public function setLastname(string $lastname): static { $this->lastname = $lastname; return $this; }
    public function getPhoto(): ?string { return $this->photo; }
    public function setPhoto(string $photo): static { $this->photo = $photo; return $this; }
    public function getStatus(): ?string { return $this->status; }
    public function setStatus(string $status): static { $this->status = $status; return $this; }
    public function getCreatedAt(): ?\DateTimeImmutable { return $this->createdAt; }
    public function setCreatedAt(\DateTimeImmutable $createdAt): static { $this->createdAt = $createdAt; return $this; }
    public function getUpdatedAt(): ?\DateTimeImmutable { return $this->updatedAt; }
    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static { $this->updatedAt = $updatedAt; return $this; }
    public function getAppUser(): ?User { return $this->appUser; }
    public function setAppUser(?User $appUser): static { $this->appUser = $appUser; return $this; }
    public function getCountry(): ?Country { return $this->country; }
    public function setCountry(?Country $country): static { $this->country = $country; return $this; }
    public function getVisits(): Collection { return $this->visits; }
}
