<?php

namespace App\Entity;


use App\Repository\VisitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\PatchVisitParticipantsController;
use App\Controller\GetVisitParticipantsController;
use ApiPlatform\Metadata\ApiSubresource;
#[ORM\Entity(repositoryClass: VisitRepository::class)]
#[ORM\HasLifecycleCallbacks]


#[ApiResource(
    operations: [
        new GetCollection(normalizationContext: ['groups' => ['visit:read']]),
        new Get(normalizationContext: ['groups' => ['visit:read']]),
        new Post(),
        new Delete(),
        new Patch(),
        new Get(
             uriTemplate: '/visits/{id}/participants',
             controller: GetVisitParticipantsController::class,
             name: 'get_visit_participants',
             read: false,
            deserialize: false
),
       new Patch(
           uriTemplate: '/visits/{id}/participants',
           controller: PatchVisitParticipantsController::class,
           name: 'patch_visit_participants',
           read: false,
          deserialize: false
),
    ],
    normalizationContext: ['groups' => ['visit:read']],
    denormalizationContext: ['groups' => ['visit:write']]
)]

class Visit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['visit:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['visit:read', 'visit:write'])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['visit:read', 'visit:write'])]
    private ?string $photo = null;

    #[ORM\Column]
    #[Groups(['visit:read', 'visit:write'])]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE)]
    #[Groups(['visit:read', 'visit:write'])]
    private ?\DateTimeImmutable $startTime = null;

    #[ORM\Column]
    #[Groups(['visit:read', 'visit:write'])]
    private ?int $duration = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE)]
    #[Groups(['visit:read'])]
    private ?\DateTimeImmutable $endTime = null;

    #[ORM\ManyToOne(inversedBy: 'visits')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['visit:read', 'visit:write'])]
    private ?Country $country = null;

    #[ORM\ManyToOne(inversedBy: 'visits')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['visit:read', 'visit:write'])]
    private ?Location $location = null;

    #[ORM\ManyToOne(inversedBy: 'visits')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['visit:read', 'visit:write'])]
    private ?Guide $guide = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['visit:read', 'visit:write'])]
    private ?string $comments = null;

    #[ORM\Column]
    #[Groups(['visit:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['visit:read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(targetEntity: VisitTourist::class, mappedBy: 'visit')]
    #[Groups(['visit:read'])]
    #[ApiSubresource]
    private Collection $visitTourists;

    #[ORM\Column(type: 'boolean')]
#[Groups(['visit:read', 'visit:write'])]
private bool $ended = false;

public function isEnded(): bool
{
    return $this->ended;
}

public function setEnded(bool $ended): static
{
    $this->ended = $ended;
    return $this;
}

    public function __construct()
    {
        $this->visitTourists = new ArrayCollection();
        $now = new \DateTimeImmutable();
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function calculateEndTime(): void
    {
        if ($this->startTime && $this->duration) {
            $start = \DateTimeImmutable::createFromFormat('H:i:s', $this->startTime->format('H:i:s'));
            if ($start) {
                $this->endTime = $start->modify("+{$this->duration} hours");
            }
        }

        $this->updatedAt = new \DateTimeImmutable();
    }

    // 🔽 Getters & Setters

    public function getId(): ?int { return $this->id; }
    public function getPhoto(): ?string { return $this->photo; }
    public function setPhoto(?string $photo): static { $this->photo = $photo; return $this; }
    public function getDate(): ?\DateTimeImmutable { return $this->date; }
    public function setDate(\DateTimeImmutable $date): static { $this->date = $date; return $this; }
    public function getStartTime(): ?\DateTimeImmutable { return $this->startTime; }
    public function setStartTime(\DateTimeImmutable $startTime): static { $this->startTime = $startTime; return $this; }
    public function getDuration(): ?int { return $this->duration; }
    public function setDuration(int $duration): static { $this->duration = $duration; return $this; }
    public function getEndTime(): ?\DateTimeImmutable { return $this->endTime; }
    public function setEndTime(\DateTimeImmutable $endTime): static { $this->endTime = $endTime; return $this; }
    public function getCountry(): ?Country { return $this->country; }
    public function setCountry(?Country $country): static { $this->country = $country; return $this; }
    public function getLocation(): ?Location { return $this->location; }
    public function setLocation(?Location $location): static { $this->location = $location; return $this; }
    public function getGuide(): ?Guide { return $this->guide; }
    public function setGuide(?Guide $guide): static { $this->guide = $guide; return $this; }
    public function getComments(): ?string { return $this->comments; }
    public function setComments(?string $comments): static { $this->comments = $comments; return $this; }
    public function getCreatedAt(): ?\DateTimeImmutable { return $this->createdAt; }
    public function setCreatedAt(\DateTimeImmutable $createdAt): static { $this->createdAt = $createdAt; return $this; }
    public function getUpdatedAt(): ?\DateTimeImmutable { return $this->updatedAt; }
    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static { $this->updatedAt = $updatedAt; return $this; }
    public function getName(): ?string { return $this->name; }
    public function setName(?string $name): static { $this->name = $name; return $this; }
    public function getVisitTourists(): Collection { return $this->visitTourists; }
    public function addVisitTourist(VisitTourist $vt): static {
        if (!$this->visitTourists->contains($vt)) {
            $this->visitTourists->add($vt);
            $vt->setVisit($this);
        }
        return $this;
    }
    public function removeVisitTourist(VisitTourist $vt): static {
        if ($this->visitTourists->removeElement($vt) && $vt->getVisit() === $this) {
            $vt->setVisit(null);
        }
        return $this;
    }
}
