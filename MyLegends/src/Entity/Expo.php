<?php

namespace App\Entity;

use App\Repository\ExpoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExpoRepository::class)]
class Expo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $descriptExpo = null;

    #[ORM\Column]
    private ?bool $publiee = null;

    #[ORM\ManyToOne(inversedBy: 'expos')]
    private ?Member $createur = null;

    #[ORM\ManyToMany(targetEntity: CarteJoueur::class, inversedBy: 'expo')]
    private Collection $cartes;



    public function __construct()
    {
        $this->cartes = new ArrayCollection();
    }
    
    public function __toString()
    {
        $s = '';
        $s .= $this->getId() .' '. $this->getDescriptExpo() .' ';
        return $s;
    }
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescriptExpo(): ?string
    {
        return $this->descriptExpo;
    }

    public function setDescriptExpo(string $descriptExpo): static
    {
        $this->descriptExpo = $descriptExpo;

        return $this;
    }

    public function isPubliee(): ?bool
    {
        return $this->publiee;
    }

    public function setPubliee(bool $publiee): static
    {
        $this->publiee = $publiee;

        return $this;
    }

    public function getCreateur(): ?Member
    {
        return $this->createur;
    }

    public function setCreateur(?Member $createur): static
    {
        $this->createur = $createur;

        return $this;
    }

    /**
     * @return Collection<int, CarteJoueur>
     */
    public function getCartes(): Collection
    {
        return $this->cartes;
    }

    public function addCarte(CarteJoueur $carte): static
    {
        if (!$this->cartes->contains($carte)) {
            $this->cartes->add($carte);
        }

        return $this;
    }

    public function removeCarte(CarteJoueur $carte): static
    {
        $this->cartes->removeElement($carte);

        return $this;
    }
}
