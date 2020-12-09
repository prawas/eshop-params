<?php

namespace Onest\EshopParamsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use App\Entity\Category;

/**
 * @ORM\Entity
 */
class CategoryGroup
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Category", mappedBy="categoryGroup", cascade={"persist","remove"})
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity="Onest\EshopParamsBundle\Entity\ParameterClass", mappedBy="categoryGroup", cascade={"persist","remove"})
     */
    private $parameters;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->parameters = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name ?? '-';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setCategoryGroup($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            // set the owning side to null (unless already changed)
            if ($category->getCategoryGroup() === $this) {
                $category->setCategoryGroup(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ParameterClass[]
     */
    public function getParameters(): Collection
    {
        return $this->parameters;
    }

    public function addParameter(ParameterClass $parameter): self
    {
        if (!$this->parameters->contains($parameter)) {
            $this->parameters[] = $parameter;
            $parameter->setCategoryGroup($this);
        }

        return $this;
    }

    public function removeParameter(ParameterClass $parameter): self
    {
        if ($this->parameters->contains($parameter)) {
            $this->parameters->removeElement($parameter);
            // set the owning side to null (unless already changed)
            if ($parameter->getCategoryGroup() === $this) {
                $parameter->setCategoryGroup(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
