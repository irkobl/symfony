<?php

namespace App\Entity;

use App\Repository\ApplicationFileRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Applications;

#[ORM\Entity(repositoryClass: ApplicationFileRepository::class)]
class ApplicationFile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'application_file')]
    #[ORM\JoinColumn(nullable: false)]
    private ?applications $name_file = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameFile(): ?applications
    {
        return $this->name_file;
    }

    public function setNameFile(?applications $name_file): self
    {
        $this->name_file = $name_file;

        return $this;
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
}
