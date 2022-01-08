<?php

namespace App\Entity;

use App\Repository\SeriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeriesRepository::class)]
class Series
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nbr_saison;

    #[ORM\ManyToMany(targetEntity: Users::class, inversedBy: 'id_series')]
    private $nbr_saison2;

    #[ORM\OneToMany(mappedBy: 'id_serie', targetEntity: Saisons::class)]
    private $nombre_saison;

    public function __construct()
    {
        $this->nbr_saison2 = new ArrayCollection();
        $this->nombre_saison = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getNbrSaison(): ?string
    {
        return $this->nbr_saison;
    }

    public function setNbrSaison(?string $nbr_saison): self
    {
        $this->nbr_saison = $nbr_saison;

        return $this;
    }

    /**
     * @return Collection|Users[]
     */
    public function getNbrSaison2(): Collection
    {
        return $this->nbr_saison2;
    }

    public function addNbrSaison2(Users $nbrSaison2): self
    {
        if (!$this->nbr_saison2->contains($nbrSaison2)) {
            $this->nbr_saison2[] = $nbrSaison2;
        }

        return $this;
    }

    public function removeNbrSaison2(Users $nbrSaison2): self
    {
        $this->nbr_saison2->removeElement($nbrSaison2);

        return $this;
    }

    /**
     * @return Collection|Saisons[]
     */
    public function getNombreSaison(): Collection
    {
        return $this->nombre_saison;
    }

    public function addNombreSaison(Saisons $nombreSaison): self
    {
        if (!$this->nombre_saison->contains($nombreSaison)) {
            $this->nombre_saison[] = $nombreSaison;
            $nombreSaison->setIdSerie($this);
        }

        return $this;
    }

    public function removeNombreSaison(Saisons $nombreSaison): self
    {
        if ($this->nombre_saison->removeElement($nombreSaison)) {
            // set the owning side to null (unless already changed)
            if ($nombreSaison->getIdSerie() === $this) {
                $nombreSaison->setIdSerie(null);
            }
        }

        return $this;
    }
}
