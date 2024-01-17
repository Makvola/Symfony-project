<?php

namespace App\Entity;

use App\Repository\MaCollectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaCollectionRepository::class)]
class MaCollection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomCollect = null;

    #[ORM\Column(length: 255)]
    private ?string $descriptCollect = null;

    #[ORM\OneToMany(mappedBy: 'maCollection', targetEntity: CarteJoueur::class, orphanRemoval: true, cascade: ["persist"])]
    private Collection $relation;

    #[ORM\ManyToOne(inversedBy: 'collection')]
    private ?Member $member = null;
    

    public function __construct()
    {
        $this->relation = new ArrayCollection();
    }
    
    public function __toString()
    {
        $s = '';
        $s .= $this->getId() .' '. $this->getNomCollect() .' ';
        return $s;
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCollect(): ?string
    {
        return $this->nomCollect;
    }

    public function setNomCollect(string $nomCollect): static
    {
        $this->nomCollect = $nomCollect;

        return $this;
    }

    public function getDescriptCollect(): ?string
    {
        return $this->descriptCollect;
    }

    public function setDescriptCollect(string $descriptCollect): static
    {
        $this->descriptCollect = $descriptCollect;

        return $this;
    }

    /**
     * @return Collection<int, CarteJoueur>
     */
    public function getRelation(): Collection
    {
        return $this->relation;
    }

    public function addRelation(CarteJoueur $relation): static
    {
        if (!$this->relation->contains($relation)) {
            $this->relation->add($relation);
            $relation->setMaCollection($this);
        }

        return $this;
    }

    public function removeRelation(CarteJoueur $relation): static
    {
        if ($this->relation->removeElement($relation)) {
            // set the owning side to null (unless already changed)
            if ($relation->getMaCollection() === $this) {
                $relation->setMaCollection(null);
            }
        }

        return $this;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): static
    {
        $this->member = $member;

        return $this;
    }
}
