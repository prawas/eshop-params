<?php

namespace Onest\EshopParamsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Onest\EshopParamsBundle\Entity\Parameter;

/**
 * @ORM\Entity
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Onest\EshopParamsBundle\Entity\Parameter", mappedBy="product", cascade={"persist", "remove"})
     */
    protected $parameters;

    public function __construct()
    {
        $this->parameters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Parameter[]
     */
    public function getParameters(): Collection
    {
        return $this->parameters;
    }

    public function addParameter(Parameter $parameter): self
    {
        if (!$this->parameters->contains($parameter)) {
            $this->parameters[] = $parameter;
            $parameter->setProduct($this);
        }

        return $this;
    }

    public function removeParameter(Parameter $parameter): self
    {
        if ($this->parameters->contains($parameter)) {
            $this->parameters->removeElement($parameter);
            // set the owning side to null (unless already changed)
            if ($parameter->getProduct() === $this) {
                $parameter->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return ParameterClass[]
     */
    public function getParametersClasses(): array
    {
        $categories = $this->getCategories();
        $result = [];
        $maxLevel = -1;
        foreach ($categories as $cat) {
            $group = $cat->getCategoryGroupWithParents();
            if ($group && $cat->getLvl() > $maxLevel) {
                $result = $group->getParameters()->toArray();
                $maxLevel = $cat->getLvl();
            }
        }
        return $result;
    }
}
