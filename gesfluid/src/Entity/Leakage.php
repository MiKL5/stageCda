<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LeakageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LeakageRepository::class)]
#[ApiResource(
  normalizationContext: ['groups' => 'leakage:read']
 )]
class Leakage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['leakage:read'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['leakage:read'])]
    private ?int $num = null;

    #[ORM\Column]
    #[Groups(['leakage:read'])]
    private ?int $count = null;

    #[ORM\Column(length: 255)]
    #[Groups(['leakage:read'])]
    private ?string $location = null;

    #[ORM\Column]
    #[Groups(['leakage:read'])]
    private ?bool $fixed = false;

    #[ORM\ManyToOne(inversedBy: 'leakage')]
    #[Groups(['leakage:read'])]
    private ?Intervention $intervention = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNum(): ?int
    {
      return $this->num;
    }

    public function setNum(int $num): self
    {
      $this->num = $num;

      return $this;
    }

    public function getCount(): ?int
    {
      return $this->count;
    }

    public function setCount(int $count): self
    {
      $this->count = $count;

      return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }


    public function getFixed(): ?bool
    {
      return $this->fixed;
    }

    public function setFixed(bool $fixed): self
    {
      $this->fixed = $fixed;

      return $this;
    }

    public function getIntervention(): ?Intervention
    {
        return $this->intervention;
    }

    public function setIntervention(?Intervention $intervention): self
    {
        $this->intervention = $intervention;

        return $this;
    }
}
