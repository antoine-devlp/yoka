<?php

namespace App\Entity;

use App\Repository\SaisonsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SaisonsRepository::class)]
class Saisons
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $num_saison;

    #[ORM\ManyToOne(targetEntity: series::class, inversedBy: 'nombre_saison')]
    #[ORM\JoinColumn(nullable: false)]
    private $id_serie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumSaison(): ?int
    {
        return $this->num_saison;
    }

    public function setNumSaison(int $num_saison): self
    {
        $this->num_saison = $num_saison;

        return $this;
    }

    public function getIdSerie(): ?series
    {
        return $this->id_serie;
    }

    public function setIdSerie(?series $id_serie): self
    {
        $this->id_serie = $id_serie;

        return $this;
    }
}
