<?php

namespace App\Entity;

use App\Repository\VisitTouristRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: VisitTouristRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['visit_tourist:read','visit:read']],
    denormalizationContext: ['groups' => ['visit_tourist:write','visit:write']]
)]
class VisitTourist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['visit_tourist:read', 'visit:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'visitTourists')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['visit_tourist:read', 'visit_tourist:write'])]
    private ?Visit $visit = null;

    #[ORM\ManyToOne(inversedBy: 'visitTourists')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['visit_tourist:read', 'visit_tourist:write', 'visit:read'])]
    private ?Tourist $tourist = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['visit_tourist:read', 'visit_tourist:write', 'visit:write', 'visit:read'])]
    private ?bool $present = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['visit_tourist:read', 'visit_tourist:write', 'visit:write', 'visit:read'])]
    private ?string $comment = null;

    #[ORM\Column]
    #[Groups(['visit_tourist:read', 'visit:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['visit_tourist:read', 'visit:read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }
    public function getVisit(): ?Visit { return $this->visit; }
    public function setVisit(?Visit $visit): static { $this->visit = $visit; return $this; }
    public function getTourist(): ?Tourist { return $this->tourist; }
    public function setTourist(?Tourist $tourist): static { $this->tourist = $tourist; return $this; }
    public function isPresent(): ?bool { return $this->present; }
    public function setPresent(bool $present): static { $this->present = $present; return $this; }
    public function getComment(): ?string { return $this->comment; }
    public function setComment(?string $comment): static { $this->comment = $comment; return $this; }
    public function getCreatedAt(): ?\DateTimeImmutable { return $this->createdAt; }
    public function getUpdatedAt(): ?\DateTimeImmutable { return $this->updatedAt; }
}

