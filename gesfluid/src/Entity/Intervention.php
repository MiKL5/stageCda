<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\InterventionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: InterventionRepository::class)]
#[ApiResource(
  normalizationContext: ['groups' => 'intervention:read'],
)]
class Intervention
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['intervention:read'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['intervention:read'])]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['intervention:read'])]
    /* Quantité de fluide vierge récupérée */
    private ?float $virginFluidQuantity = null;

    /* Quantité de fluide recyclé récupérée */
    #[ORM\Column(nullable: true)]
    #[Groups(['intervention:read'])]
    private ?float $recycledFluidQuantity = null;

    /* Quantité de fluide régénéré récupérée */
    #[ORM\Column(nullable: true)]
    #[Groups(['intervention:read'])]
    private ?float $regeneratedFluidQuantity = null;

    /* Quantité récupérée de fluide destiné au traitement */
    #[ORM\Column(nullable: true)]
    #[Groups(['intervention:read'])]
    private ?float $forProcessingFluidQuantity = null;

    /* Numéro du BSFF (trackdéchets) : Bordereau de Suivi de Fluide Frigorigène */
    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['intervention:read'])]
    private ?string $bsffNumber = null;

    /* Quantité de fluide conservée pour réutilisation */
    #[ORM\Column(nullable: true)]
    #[Groups(['intervention:read'])]
    private ?float $reusableFluidQuantity = null;

    /* Installation prévue de destination du fluide récupéré */
    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['intervention:read'])]
    private ?string $collectedFluidDestination = null;

    /* Observations */
    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['intervention:read'])]
    private ?string $remarks = null;

    /* Type d'intervention */
    #[ORM\ManyToOne(inversedBy: 'interventions')]
    #[Groups(['intervention:read'])]
    private ?InterventionType $interventionType = null;

    /* Texte libre lorsque le type d'intervention autre est sélectionné */
    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['intervention:read)'])]
    private ?string $otherInterventionType = null;

    /* Booleen pour signifier qu'une ou plusieurs fuites ont été détectées */
    #[ORM\Column]
    #[Groups(['intervention:read'])]
    private ?bool $leaks = null;

    /* Equipement concerné */
    #[ORM\ManyToOne(inversedBy: 'interventions')]
    #[Groups(['intervention:read'])]
    private ?Equipment $equipment = null;

    /* Contenant concerné */
    #[ORM\ManyToOne(inversedBy: 'interventions')]
    #[Groups(['intervention:read'])]
    private ?Container $container = null;

    /* Fuite(s) détectée(s) */
    #[ORM\OneToMany(mappedBy: 'intervention', targetEntity: Leakage::class, cascade: ['remove'])]
    #[Groups(['intervention:read'])]
    private Collection $leakage;

    /* Détecteur de fuites utilisé */
    #[ORM\ManyToOne(inversedBy: 'interventions')]
    #[Groups(['intervention:read'])]
    private ?Accessory $accessory = null;

    /* Utilisateur */
    #[ORM\ManyToOne(inversedBy: 'interventions')]
    #[Groups(['intervention:read'])]
    private ?User $user = null;

    /* Chemin du fichier pdf généré */
    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['intervention:read'])]
    private ?string $pdfPath = null;

    public function __construct()
    {
        $this->leakage = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getVirginFluidQuantity(): ?float
    {
        return $this->virginFluidQuantity;
    }

    public function setVirginFluidQuantity(?float $virginFluidQuantity): self
    {
        $this->virginFluidQuantity = $virginFluidQuantity;

        return $this;
    }

    public function getRecycledFluidQuantity(): ?float
    {
        return $this->recycledFluidQuantity;
    }

    public function setRecycledFluidQuantity(?float $recycledFluidQuantity): self
    {
        $this->recycledFluidQuantity = $recycledFluidQuantity;

        return $this;
    }

    public function getRegeneratedFluidQuantity(): ?float
    {
        return $this->regeneratedFluidQuantity;
    }

    public function setRegeneratedFluidQuantity(?float $regeneratedFluidQuantity): self
    {
        $this->regeneratedFluidQuantity = $regeneratedFluidQuantity;

        return $this;
    }

    public function getForProcessingFluidQuantity(): ?float
    {
        return $this->forProcessingFluidQuantity;
    }

    public function setForProcessingFluidQuantity(?float $forProcessingFluidQuantity): self
    {
        $this->forProcessingFluidQuantity = $forProcessingFluidQuantity;

        return $this;
    }

    public function getBsffNumber(): ?string
    {
        return $this->bsffNumber;
    }

    public function setBsffNumber(?string $bsffNumber): self
    {
        $this->bsffNumber = $bsffNumber;

        return $this;
    }

    public function getReusableFluidQuantity(): ?float
    {
        return $this->reusableFluidQuantity;
    }

    public function setReusableFluidQuantity(?float $reusableFluidQuantity): self
    {
        $this->reusableFluidQuantity = $reusableFluidQuantity;

        return $this;
    }

    public function getCollectedFluidDestination(): ?string
    {
        return $this->collectedFluidDestination;
    }

    public function setCollectedFluidDestination(?string $collectedFluidDestination): self
    {
        $this->collectedFluidDestination = $collectedFluidDestination;

        return $this;
    }

    public function getRemarks(): ?string
    {
        return $this->remarks;
    }

    public function setRemarks(?string $remarks): self
    {
        $this->remarks = $remarks;

        return $this;
    }

    public function getInterventionType(): ?InterventionType
    {
        return $this->interventionType;
    }

    public function setInterventionType(?InterventionType $interventionType): self
    {
        $this->interventionType = $interventionType;

        return $this;
    }

    public function getOtherInterventionType(): ?string
    {
      return $this->otherInterventionType;
    }

    public function setOtherInterventionType(?string $otherInterventionType): self
    {
      $this->otherInterventionType = $otherInterventionType;

      return $this;
    }

    public function getLeaks(): ?bool
    {
      return $this->leaks;
    }


    public function setLeaks(bool $leaks) : self
    {
      $this->leaks = $leaks;

      return $this;
    }

    public function getEquipment(): ?Equipment
    {
        return $this->equipment;
    }

    public function setEquipment(?Equipment $equipment): self
    {
        $this->equipment = $equipment;

        return $this;
    }

    public function getContainer(): ?Container
    {
        return $this->container;
    }

    public function setContainer(?Container $container): self
    {
        $this->container = $container;

        return $this;
    }

    /**
     * @return Collection<int, Leakage>
     */
    public function getLeakage(): Collection
    {
        return $this->leakage;
    }

    public function addLeakage(Leakage $leakage): self
    {
        if (!$this->leakage->contains($leakage)) {
            $this->leakage->add($leakage);
            $leakage->setIntervention($this);
        }

        return $this;
    }

    public function removeLeakage(Leakage $leakage): self
    {
        if ($this->leakage->removeElement($leakage)) {
            // set the owning side to null (unless already changed)
            if ($leakage->getIntervention() === $this) {
                $leakage->setIntervention(null);
            }
        }

        return $this;
    }

    public function getAccessory(): ?Accessory
    {
        return $this->accessory;
    }

    public function setAccessory(?Accessory $accessory): self
    {
        $this->accessory = $accessory;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPdfPath(): ?string
    {
      return $this->pdfPath;
    }

    public function setPdfPath(?string $pdfPath): self
    {
      $this->pdfPath = $pdfPath;

      return $this;
    }
}
