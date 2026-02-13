<?php
namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\{ArrayCollection, Collection};
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Attribute as Vich;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[Vich\Uploadable]
class Category
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private string $title;

    #[ORM\Column(length: 255)]
    private string $image = '';

    #[Vich\UploadableField(mapping: 'category_images', fileNameProperty: 'image')]
    public ?File $file = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    /** @var Collection<int, Dossier> */
    #[ORM\ManyToMany(targetEntity: Dossier::class, inversedBy: 'categories')]
    private Collection $dossier;

    public function __construct()
    {
        $this->dossier = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getTitle();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function setImageFile(?File $image = null): self
    {
        $this->file = $image;

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->file;
    }

    /** @return Collection<int, Dossier> */
    public function getDossier(): Collection
    {
        return $this->dossier;
    }

    public function addDossier(Dossier $dossier): self
    {
        if (!$this->dossier->contains($dossier)) {
            $this->dossier[] = $dossier;
        }

        return $this;
    }

    public function removeDossier(Dossier $dossier): self
    {
        if ($this->dossier->contains($dossier)) {
            $this->dossier->removeElement($dossier);
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    #[ORM\PreUpdate]
    public function setUpdatedAt(): self
    {
        $this->updatedAt = new \DateTimeImmutable();

        return $this;
    }
}
