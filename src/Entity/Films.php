<?php

namespace App\Entity;

use App\Repository\FilmsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FilmsRepository::class)]
class Films
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\ManyToMany(targetEntity: Users::class, inversedBy: 'id_films')]
    private $id_users;

    public function __construct()
    {
        $this->id_users = new ArrayCollection();
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

    /**
     * @return Collection|Users[]
     */
    public function getIdUsers(): Collection
    {
        return $this->id_users;
    }

    public function addIdUser(Users $idUser): self
    {
        if (!$this->id_users->contains($idUser)) {
            $this->id_users[] = $idUser;
        }

        return $this;
    }

    public function removeIdUser(Users $idUser): self
    {
        $this->id_users->removeElement($idUser);

        return $this;
    }
}
