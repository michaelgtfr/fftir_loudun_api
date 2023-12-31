<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Expr\Cast\Object_;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: TagRepository::class)]
#[UniqueEntity('name', 'message: le champ "name" doit être unique')]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    private ?string $presentation = null;

    #[ORM\Column(type: Types::ARRAY)]
    #[Assert\NotBlank (message: 'la valeur "style" ne peux pas être vide')]
    #[Assert\Type('array')]
    private array $style = [];

    #[ORM\ManyToMany(targetEntity: BlogPost::class, mappedBy: 'relation')]
    private Collection $blogPosts;

    public function __construct()
    {
        $this->blogPosts = new ArrayCollection();
    }


    public function hydrateDTO(array $tag)
    {
        foreach($tag as $key => $value) {
            if ($key != 'id') {
                $attribute ='set'. ucfirst($key);
                $this->$attribute($value);
            }
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): static
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getStyle(): array
    {
        return $this->style;
    }

    public function setStyle(array $style): static
    {
        $this->style = $style;

        return $this;
    }

    /**
     * @return Collection<int, BlogPost>
     */
    public function getBlogPosts(): Collection
    {
        return $this->blogPosts;
    }

    public function addBlogPost(BlogPost $blogPost): static
    {
        if (!$this->blogPosts->contains($blogPost)) {
            $this->blogPosts->add($blogPost);
            $blogPost->addRelation($this);
        }

        return $this;
    }

    public function removeBlogPost(BlogPost $blogPost): static
    {
        if ($this->blogPosts->removeElement($blogPost)) {
            $blogPost->removeRelation($this);
        }

        return $this;
    }
}
