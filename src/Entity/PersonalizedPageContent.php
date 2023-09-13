<?php

namespace App\Entity;

use App\Repository\PersonalizedPageContentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Self_;

#[ORM\Entity(repositoryClass: PersonalizedPageContentRepository::class)]
class PersonalizedPageContent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $page = null;

    #[ORM\Column(length: 100)]
    private ?string $subpart = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    private const LIST_POSSIBLE_PAGES = [
        self::HOMEPAGE
    ];

    public const HOMEPAGE = 'homepage';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPage(): ?string
    {
        return $this->page;
    }

    public function setPage(string $page): static
    {
        $this->page = $page;

        return $this;
    }

    public function getSubpart(): ?string
    {
        return $this->subpart;
    }

    public function setSubpart(string $subpart): static
    {
        $this->subpart = $subpart;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public static function checkThePresenceOfTheRequestedPageInTheList(string $page)
    {
        return in_array($page, Self::LIST_POSSIBLE_PAGES);
    }
}
