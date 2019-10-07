<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VisiteRepository")
 */
class Visite
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Bien")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_bien;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Visiteur")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_visiteur;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $suite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdBien(): ?Bien
    {
        return $this->id_bien;
    }

    public function setIdBien(?Bien $id_bien): self
    {
        $this->id_bien = $id_bien;

        return $this;
    }

    public function getIdVisiteur(): ?Visiteur
    {
        return $this->id_visiteur;
    }

    public function setIdVisiteur(?Visiteur $id_visiteur): self
    {
        $this->id_visiteur = $id_visiteur;

        return $this;
    }

    public function getSuite(): ?string
    {
        return $this->suite;
    }

    public function setSuite(string $suite): self
    {
        $this->suite = $suite;

        return $this;
    }
}
