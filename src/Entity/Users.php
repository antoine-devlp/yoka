<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $pseudo;

    #[ORM\Column(type: 'string', length: 255)]
    private $password;

    #[ORM\ManyToMany(targetEntity: Series::class, mappedBy: 'nbr_saison2')]
    private $id_series;

    #[ORM\ManyToMany(targetEntity: Films::class, mappedBy: 'id_users')]
    private $id_films;

    public function __construct()
    {
        $this->id_series = new ArrayCollection();
        $this->id_films = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection|Series[]
     */
    public function getIdSeries(): Collection
    {
        return $this->id_series;
    }

    public function addIdSeries(Series $idSeries): self
    {
        if (!$this->id_series->contains($idSeries)) {
            $this->id_series[] = $idSeries;
            $idSeries->addNbrSaison2($this);
        }

        return $this;
    }

    public function removeIdSeries(Series $idSeries): self
    {
        if ($this->id_series->removeElement($idSeries)) {
            $idSeries->removeNbrSaison2($this);
        }

        return $this;
    }

    /**
     * @return Collection|Films[]
     */
    public function getIdFilms(): Collection
    {
        return $this->id_films;
    }

    public function addIdFilm(Films $idFilm): self
    {
        if (!$this->id_films->contains($idFilm)) {
            $this->id_films[] = $idFilm;
            $idFilm->addIdUser($this);
        }

        return $this;
    }

    public function removeIdFilm(Films $idFilm): self
    {
        if ($this->id_films->removeElement($idFilm)) {
            $idFilm->removeIdUser($this);
        }

        return $this;
    }
}
