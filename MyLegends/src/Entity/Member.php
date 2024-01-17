<?php

namespace App\Entity;

use App\Repository\MemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MemberRepository::class)]
class Member
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomMembre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descriptMembre = null;

    #[ORM\Column(length: 255)]
    private ?string $paysMembre = null;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: MaCollection::class)]
    private Collection $collection;

    #[ORM\OneToMany(mappedBy: 'createur', targetEntity: Expo::class)]
    private Collection $expos;

    #[ORM\OneToOne(inversedBy: 'member', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    public function __construct()
    {
        $this->collection = new ArrayCollection();
        $this->expos = new ArrayCollection();
    }
    
    public function __toString()
    {
        $s = '';
        $s .= $this->getId() .' '. $this->getNomMembre() .' ';
        return $s;
    }
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomMembre(): ?string
    {
        return $this->nomMembre;
    }

    public function setNomMembre(string $nomMembre): static
    {
        $this->nomMembre = $nomMembre;

        return $this;
    }

    public function getDescriptMembre(): ?string
    {
        return $this->descriptMembre;
    }

    public function setDescriptMembre(?string $descriptMembre): static
    {
        $this->descriptMembre = $descriptMembre;

        return $this;
    }

    public function getPaysMembre(): ?string
    {
        return $this->paysMembre;
    }

    public function setPaysMembre(string $paysMembre): static
    {
        $this->paysMembre = $paysMembre;

        return $this;
    }

    /**
     * @return Collection<int, MaCollection>
     */
    public function getCollection(): Collection
    {
        return $this->collection;
    }

    public function addCollection(MaCollection $collection): static
    {
        if (!$this->collection->contains($collection)) {
            $this->collection->add($collection);
            $collection->setMember($this);
        }

        return $this;
    }

    public function removeCollection(MaCollection $collection): static
    {
        if ($this->collection->removeElement($collection)) {
            // set the owning side to null (unless already changed)
            if ($collection->getMember() === $this) {
                $collection->setMember(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Expo>
     */
    public function getExpos(): Collection
    {
        return $this->expos;
    }

    public function addExpo(Expo $expo): static
    {
        if (!$this->expos->contains($expo)) {
            $this->expos->add($expo);
            $expo->setCreateur($this);
        }

        return $this;
    }

    public function removeExpo(Expo $expo): static
    {
        if ($this->expos->removeElement($expo)) {
            // set the owning side to null (unless already changed)
            if ($expo->getCreateur() === $this) {
                $expo->setCreateur(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
