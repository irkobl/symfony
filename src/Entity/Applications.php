<?php

namespace App\Entity;

use App\Repository\ApplicationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $text = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $status = null;

    #[Gedmo\Timestampable(on:"create")] //авто установка времени
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $created_at = null;

    #[Gedmo\Timestampable(on:"update")] //авто обновление времени
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\OneToMany(mappedBy: 'name_file', targetEntity: ApplicationFile::class, cascade:['persist'])]
    private Collection $application_file;

    public function __construct()
    {
        $this->application_file = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

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

    /**
     * @return Collection<int, ApplicationFile>
     */
    public function getApplicationFile(): Collection
    {
        return $this->application_file;
    }

    public function addApplicationFile(ApplicationFile $applicationFile): self
    {
        if (!$this->application_file->contains($applicationFile)) {
            $this->application_file->add($applicationFile);
            $applicationFile->setNameFile($this);
        }

        return $this;
    }

    public function removeApplicationFile(ApplicationFile $applicationFile): self
    {
        if ($this->application_file->removeElement($applicationFile)) {
            // set the owning side to null (unless already changed)
            if ($applicationFile->getNameFile() === $this) {
                $applicationFile->setNameFile(null);
            }
        }

        return $this;
    }
}
