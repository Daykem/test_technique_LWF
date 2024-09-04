<?php

namespace App\Entity;

use App\Repository\ArticleBoutiqueRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleBoutiqueRepository::class)]
class ArticleBoutique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'articleBoutiques')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Article $article = null;

    #[ORM\ManyToOne(inversedBy: 'articleBoutiques')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Boutique $boutique = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $tarifLocationJour = null;

    #[ORM\Column]
    private ?int $stock = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): static
    {
        $this->article = $article;

        return $this;
    }

    public function getBoutique(): ?Boutique
    {
        return $this->boutique;
    }

    public function setBoutique(?Boutique $boutique): static
    {
        $this->boutique = $boutique;

        return $this;
    }

    public function getTarifLocationJour(): ?string
    {
        return $this->tarifLocationJour;
    }

    public function setTarifLocationJour(string $tarifLocationJour): static
    {
        $this->tarifLocationJour = $tarifLocationJour;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }
}
