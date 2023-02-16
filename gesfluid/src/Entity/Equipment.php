<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\EquipmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: EquipmentRepository::class)]
#[ApiResource(
  normalizationContext: ['groups' => 'equipment:read']
)]
class Equipment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['equipment:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['equipment:read'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['equipment:read'])]
    private ?float $weight = null;

    #[ORM\Column]
    #[Groups(['equipment:read'])]
    private ?float $co2EqTonnage = null;

    #[ORM\Column]
    #[Groups(['equipment:read'])]
    private ?bool $leakDetectionSystem = false;

    #[ORM\Column]
    #[Groups(['equipment:read'])]
    private ?int $controlFrequency = null;
    
    #[ORM\ManyToOne(inversedBy: 'equipment')]
    #[Groups(['equipment:read'])]
    private ?Fluid $fluid = null;

    #[ORM\OneToMany(mappedBy: 'equipment', targetEntity: Intervention::class)]
    #[Groups(['equipment:read'])]
    private Collection $interventions;

    public function __construct()
    {
        $this->interventions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getCo2EqTonnage(): ?float
    {
        return $this->co2EqTonnage;
    }

    public function setCo2EqTonnage(float $co2EqTonnage): self
    {
        $this->co2EqTonnage = $co2EqTonnage;

        return $this;
    }

    public function getLeakDetectionSystem(): ?bool
    {
      return $this->leakDetectionSystem;
    }

    public function setLeakDetectionSystem(bool $leakDetectionSystem): self
    {
      $this->leakDetectionSystem = $leakDetectionSystem;

      return $this;
    }

    public function getControlFrequency(): ?int
    {
      return $this->controlFrequency;
    }

    public function setControlFrequency($controlFrequency): self
    {
      $this->controlFrequency = $controlFrequency;

      return $this;
    }

    public function getFluid(): ?Fluid
    {
        return $this->fluid;
    }

    public function setFluid(?Fluid $fluid): self
    {
        $this->fluid = $fluid;

        return $this;
    }

    /**
     * @return Collection<int, Intervention>
     */
    public function getInterventions(): Collection
    {
        return $this->interventions;
    }

    public function addIntervention(Intervention $intervention): self
    {
        if (!$this->interventions->contains($intervention)) {
            $this->interventions->add($intervention);
            $intervention->setEquipment($this);
        }

        return $this;
    }

    public function removeIntervention(Intervention $intervention): self
    {
        if ($this->interventions->removeElement($intervention)) {
            // set the owning side to null (unless already changed)
            if ($intervention->getEquipment() === $this) {
                $intervention->setEquipment(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
      return $this->name;
    }
}
