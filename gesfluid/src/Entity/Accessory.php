<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AccessoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AccessoryRepository::class)]
#[ApiResource(
  normalizationContext: ['groups' => 'read:accessory']
 )]
class Accessory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('read:accessory')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('read:accessory')]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups('read:accessory')]
    private ?\DateTimeInterface $controlDate = null;

    #[ORM\Column]
    #[Groups('read:accessory')]
    private ?bool $detector = null;

    #[ORM\OneToMany(mappedBy: 'accessory', targetEntity: Intervention::class)]
    #[Groups('read:accessory')]
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

    public function getControlDate(): ?\DateTimeInterface
    {
        return $this->controlDate;
    }

    public function setControlDate(\DateTimeInterface $controlDate): self
    {
        $this->controlDate = $controlDate;

        return $this;
    }

    public function getDetector(): ?bool
    {
      return $this->detector;
    }

    public function setDetector(bool $detector): self
    {
      $this->detector = $detector;

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
            $intervention->setAccessory($this);
        }

        return $this;
    }

    public function removeIntervention(Intervention $intervention): self
    {
        if ($this->interventions->removeElement($intervention)) {
            // set the owning side to null (unless already changed)
            if ($intervention->getAccessory() === $this) {
                $intervention->setAccessory(null);
            }
        }

        return $this;
    }
}
