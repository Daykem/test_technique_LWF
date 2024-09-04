<?php

namespace App\Entity;

use App\Repository\BoutiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoutiqueRepository::class)]
class Boutique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /**
     * @var Collection<int, ArticleBoutique>
     */
    #[ORM\OneToMany(targetEntity: ArticleBoutique::class, mappedBy: 'boutique')]
    private Collection $articleBoutiques;

    public function __construct()
    {
        $this->articleBoutiques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, ArticleBoutique>
     */
    public function getArticleBoutiques(): Collection
    {
        return $this->articleBoutiques;
    }

    public function addArticleBoutique(ArticleBoutique $articleBoutique): static
    {
        if (!$this->articleBoutiques->contains($articleBoutique)) {
            $this->articleBoutiques->add($articleBoutique);
            $articleBoutique->setBoutique($this);
        }

        return $this;
    }

    public function removeArticleBoutique(ArticleBoutique $articleBoutique): static
    {
        if ($this->articleBoutiques->removeElement($articleBoutique)) {
            // set the owning side to null (unless already changed)
            if ($articleBoutique->getBoutique() === $this) {
                $articleBoutique->setBoutique(null);
            }
        }

        return $this;
    }
}
