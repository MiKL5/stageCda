<?php

namespace App\Entity;

use App\Repository\ArtistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArtistRepository::class)]
class Artist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $artist_name;

    #[ORM\Column(type: 'string', length: 255)]
    private $artist_url;

    #[ORM\OneToMany(mappedBy: 'artist', targetEntity: Disc::class)]
    private $discs;

    public function __construct()
    {
        $this->discs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    // le setter change l'info alors que le getter la récupère
    public function setId(int $id): self
    {
        $this->id = $id; // affecte un nv id
        return $this; //retourne l'obj à jour
    }

    public function getArtistName(): ?string
    {
        return $this->artist_name;
    }

    public function setArtistName(string $artist_name): self
    {
        $this->artist_name = $artist_name;

        return $this;
    }

    public function getArtistUrl(): ?string
    {
        return $this->artist_url;
    }

    // le setter change l'info alors que le getter la récupère
    public function setArtistUrl(string $artist_url): self
    {
        $this->artist_url = $artist_url; // affecte un nv id

        return $this; //retourne l'obj à jour
    }

    /**
     * @return Collection<int, Disc>
     */
    public function getDiscs(): Collection
    {
        return $this->discs;
    }

    public function addDisc(Disc $disc): self
    {
        if (!$this->discs->contains($disc)) {
            $this->discs[] = $disc;
            $disc->setArtist($this);
        }

        return $this;
    }

    public function removeDisc(Disc $disc): self
    {
        if ($this->discs->removeElement($disc)) {
            // set the owning side to null (unless already changed)
            if ($disc->getArtist() === $this) {
                $disc->setArtist(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->artist_name;
    }
}
