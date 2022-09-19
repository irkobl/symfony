<?php

namespace App\Entity;

use App\Repository\ApplicationsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: ApplicationsRepository::class)]
class Applications
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    #[ORM\Column(length: 100)]
    private ?string $status = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $file_1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $file_2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $file_3 = null;

    #[Gedmo\Timestampable(on:"create")]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $created_at = null;

    #[Gedmo\Timestampable(on:"update")]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getFile1(): ?string
    {
        return $this->file_1;
    }

    public function setFile1(?string $file_1): self
    {
        $this->file_1 = $file_1;

        return $this;
    }

    public function getFile2(): ?string
    {
        return $this->file_2;
    }

    public function setFile2(?string $file_2): self
    {
        $this->file_2 = $file_2;

        return $this;
    }

    public function getFile3(): ?string
    {
        return $this->file_3;
    }

    public function setFile3(?string $file_3): self
    {
        $this->file_3 = $file_3;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
