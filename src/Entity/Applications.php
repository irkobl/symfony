<?php

namespace App\Entity;

use App\Repository\ApplicationsRepository;
<<<<<<< HEAD
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
=======
>>>>>>> 3b3d23ce2b099a95547e076269523c946dd2a493
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

<<<<<<< HEAD
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

=======
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

>>>>>>> 3b3d23ce2b099a95547e076269523c946dd2a493
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

<<<<<<< HEAD
    public function setTitle(?string $title): self
=======
    public function setTitle(string $title): self
>>>>>>> 3b3d23ce2b099a95547e076269523c946dd2a493
    {
        $this->title = $title;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

<<<<<<< HEAD
    public function setText(?string $text): self
=======
    public function setText(string $text): self
>>>>>>> 3b3d23ce2b099a95547e076269523c946dd2a493
    {
        $this->text = $text;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

<<<<<<< HEAD
    public function setStatus(?string $status): self
=======
    public function setStatus(string $status): self
>>>>>>> 3b3d23ce2b099a95547e076269523c946dd2a493
    {
        $this->status = $status;

        return $this;
    }

<<<<<<< HEAD
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;
=======
    public function getFile1(): ?string
    {
        return $this->file_1;
    }

    public function setFile1(?string $file_1): self
    {
        $this->file_1 = $file_1;
>>>>>>> 3b3d23ce2b099a95547e076269523c946dd2a493

        return $this;
    }

<<<<<<< HEAD
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;
=======
    public function getFile2(): ?string
    {
        return $this->file_2;
    }

    public function setFile2(?string $file_2): self
    {
        $this->file_2 = $file_2;
>>>>>>> 3b3d23ce2b099a95547e076269523c946dd2a493

        return $this;
    }

<<<<<<< HEAD
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
=======
    public function getFile3(): ?string
    {
        return $this->file_3;
    }

    public function setFile3(?string $file_3): self
    {
        $this->file_3 = $file_3;
>>>>>>> 3b3d23ce2b099a95547e076269523c946dd2a493

        return $this;
    }

<<<<<<< HEAD
    public function removeApplicationFile(ApplicationFile $applicationFile): self
    {
        if ($this->application_file->removeElement($applicationFile)) {
            // set the owning side to null (unless already changed)
            if ($applicationFile->getNameFile() === $this) {
                $applicationFile->setNameFile(null);
            }
        }
=======
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
>>>>>>> 3b3d23ce2b099a95547e076269523c946dd2a493

        return $this;
    }
}
