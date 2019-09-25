<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 */
class Tag
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ArticleTag", mappedBy="tag", orphanRemoval=true)
     */
    private $articleTags;

    public function __construct()
    {
        $this->articleTags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|ArticleTag[]
     */
    public function getArticleTags(): Collection
    {
        return $this->articleTags;
    }

    public function addArticleTag(ArticleTag $articleTag): self
    {
        if (!$this->articleTags->contains($articleTag)) {
            $this->articleTags[] = $articleTag;
            $articleTag->setTag($this);
        }

        return $this;
    }

    public function removeArticleTag(ArticleTag $articleTag): self
    {
        if ($this->articleTags->contains($articleTag)) {
            $this->articleTags->removeElement($articleTag);
            // set the owning side to null (unless already changed)
            if ($articleTag->getTag() === $this) {
                $articleTag->setTag(null);
            }
        }

        return $this;
    }
}
