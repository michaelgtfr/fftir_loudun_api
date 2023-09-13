<?php

namespace App\Entity;

use App\Repository\SportsShootingDisciplinesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SportsShootingDisciplinesRepository::class)]
class SportsShootingDisciplines
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $discipline = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $presentation = null;

    #[ORM\Column(length: 255)]
    private ?string $disciplinePicture = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDiscipline(): ?string
    {
        return $this->discipline;
    }

    public function setDiscipline(string $discipline): static
    {
        $this->discipline = $discipline;

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

    public function getDisciplinePicture(): ?string
    {
        return $this->disciplinePicture;
    }

    public function setDisciplinePicture(string $disciplinePicture): static
    {
        $this->disciplinePicture = $disciplinePicture;

        return $this;
    }
}
