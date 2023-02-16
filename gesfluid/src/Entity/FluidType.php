<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FluidTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FluidTypeRepository::class)]
#[ApiResource(
  normalizationContext: ['groups' => 'fluid_type:read']
 )]
class FluidType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['equipment:read','fluid:read', 'fluid_type:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['equipment:read', 'fluid:read', 'fluid_type:read'])]
    private ?string $name = null;
    
    #[ORM\Column]
    #[Groups(['equipment:read', 'fluid:read', 'fluid_type:read'])]
    private ?bool $flammable = false;
    
    #[ORM\OneToMany(mappedBy: 'fluidType', targetEntity: Fluid::class)]
    #[Groups(['fluid_type:read'])]
    private Collection $fluids;

    public function __construct()
    {
        $this->fluids = new ArrayCollection();
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

    public function getFlammable(): ?bool
    {
      return $this->flammable;
    }

    public function setFlammable($flammable): self
    {
      $this->flammable = $flammable;

      return $this;
    }

    /**
     * @return Collection<int, Fluid>
     */
    public function getFluids(): Collection
    {
        return $this->fluids;
    }

    public function addFluid(Fluid $fluid): self
    {
        if (!$this->fluids->contains($fluid)) {
            $this->fluids->add($fluid);
            $fluid->setFluidType($this);
        }

        return $this;
    }

    public function removeFluid(Fluid $fluid): self
    {
        if ($this->fluids->removeElement($fluid)) {
            // set the owning side to null (unless already changed)
            if ($fluid->getFluidType() === $this) {
                $fluid->setFluidType(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
      return $this->name;
    }
}
