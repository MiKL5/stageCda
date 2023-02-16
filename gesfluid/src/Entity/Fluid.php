<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FluidRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Query\Expr\Func;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FluidRepository::class)]
#[ApiResource(
   normalizationContext: ['groups' => 'fluid:read']
 )]
class Fluid
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['equipment:read', 'container:read', 'fluid:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['equipment:read', 'fluid:read'])]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'fluid', targetEntity: Container::class)]
    #[Groups(['fluid:read'])]
    private Collection $containers;

    #[ORM\ManyToOne(inversedBy: 'fluids')]
    #[Groups(['container:read', 'fluid:read', 'equipment:read'])]
    private ?FluidType $fluidType = null;

    #[ORM\OneToMany(mappedBy: 'fluid', targetEntity: Equipment::class)]
    #[Groups(['container:read', 'fluid:read'])]
    private Collection $equipment;

    public function __construct()
    {
        $this->containers = new ArrayCollection();
        $this->equipment = new ArrayCollection();
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

    /**
     * @return Collection<int, Container>
     */
    public function getContainers(): Collection
    {
        return $this->containers;
    }

    public function addContainer(Container $container): self
    {
        if (!$this->containers->contains($container)) {
            $this->containers->add($container);
            $container->setFluid($this);
        }

        return $this;
    }

    public function removeContainer(Container $container): self
    {
        if ($this->containers->removeElement($container)) {
            // set the owning side to null (unless already changed)
            if ($container->getFluid() === $this) {
                $container->setFluid(null);
            }
        }

        return $this;
    }

    public function getFluidType(): ?FluidType
    {
        return $this->fluidType;
    }

    public function setFluidType(?FluidType $fluidType): self
    {
        $this->fluidType = $fluidType;

        return $this;
    }

    /**
     * @return Collection<int, Equipment>
     */
    public function getEquipment(): Collection
    {
        return $this->equipment;
    }

    public function addEquipment(Equipment $equipment): self
    {
        if (!$this->equipment->contains($equipment)) {
            $this->equipment->add($equipment);
            $equipment->setFluid($this);
        }

        return $this;
    }

    public function removeEquipment(Equipment $equipment): self
    {
        if ($this->equipment->removeElement($equipment)) {
            // set the owning side to null (unless already changed)
            if ($equipment->getFluid() === $this) {
                $equipment->setFluid(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
      return $this->name;
    }
}
