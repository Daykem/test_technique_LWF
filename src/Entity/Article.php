<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $prix = null;

    /**
     * @var Collection<int, ArticleBoutique>
     */
    #[ORM\OneToMany(targetEntity: ArticleBoutique::class, mappedBy: 'article')]
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

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): static
    {
        $this->prix = $prix;

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
            $articleBoutique->setArticle($this);
        }

        return $this;
    }

    public function removeArticleBoutique(ArticleBoutique $articleBoutique): static
    {
        if ($this->articleBoutiques->removeElement($articleBoutique)) {
            // set the owning side to null (unless already changed)
            if ($articleBoutique->getArticle() === $this) {
                $articleBoutique->setArticle(null);
            }
        }

        return $this;
    }
}
