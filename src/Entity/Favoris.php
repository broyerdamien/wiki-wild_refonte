<?php

namespace App\Entity;

use App\Repository\FavorisRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavorisRepository::class)]
class Favoris
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'favoris')]
    private ?Documentation $documentation = null;

    #[ORM\ManyToOne(inversedBy: 'DocumenationFavoris')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDocumentation(): ?Documentation
    {
        return $this->documentation;
    }

    public function setDocumentation(?Documentation $documentation): self
    {
        $this->documentation = $documentation;

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
}
