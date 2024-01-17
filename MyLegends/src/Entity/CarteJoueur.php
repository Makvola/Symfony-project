<?php

namespace App\Entity;

use App\Repository\CarteJoueurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarteJoueurRepository::class)]
class CarteJoueur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomJoueur = null;

    #[ORM\Column(length: 255)]
    private ?string $pays = null;
    
    #[ORM\Column(length: 255)]
    private ?string $poste = null;

    #[ORM\ManyToOne(inversedBy: 'relation')]
    private ?MaCollection $maCollection = null;

    #[ORM\ManyToMany(targetEntity: Expo::class, mappedBy: 'cartes')]
    private Collection $expo;

    public function __construct()
    {
        $this->expo = new ArrayCollection();
    }
    
    public function __toString()
    {
        $s = '';
        $s .= $this->getId() .' '. $this->getNomJoueur() .' ';
        return $s;
    }
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomJoueur(): ?string
    {
        return $this->nomJoueur;
    }

    public function setNomJoueur(string $nomJoueur): static
    {
        $this->nomJoueur = $nomJoueur;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): static
    {
        $this->pays = $pays;

        return $this;
    }

    public function getPoste(): ?string
    {
        return $this->poste;
    }

    public function setPoste(string $poste): static
    {
        $this->poste = $poste;

        return $this;
    }

    public function getMaCollection(): ?MaCollection
    {
        return $this->maCollection;
    }

    public function setMaCollection(?MaCollection $maCollection): static
    {
        $this->maCollection = $maCollection;

        return $this;
    }

    /**
     * @return Collection<int, Expo>
     */

    public function addExpo(Expo $expo): static
    {
        if (!$this->expos->contains($expo)) {
            $this->expos->add($expo);
            $expo->addCarte($this);
        }

        return $this;
    }

    public function removeExpo(Expo $expo): static
    {
        if ($this->expos->removeElement($expo)) {
            $expo->removeCarte($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Expo>
     */
    public function getExpo(): Collection
    {
        return $this->expo;
    }
    
}
