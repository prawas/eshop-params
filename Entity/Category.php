<?php

namespace Onest\EshopParamsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Onest\EshopParamsBundle\Entity\CategoryGroup;

/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Onest\EshopParamsBundle\Entity\CategoryGroup", inversedBy="categories")
     */
    protected $categoryGroup;

    public function getCategoryGroup(): ?CategoryGroup
    {
        return $this->categoryGroup;
    }

    public function setCategoryGroup(?CategoryGroup $categoryGroup): self
    {
        $this->categoryGroup = $categoryGroup;

        return $this;
    }

    public function getCategoryGroupWithParents(): ?CategoryGroup
    {
        $c = $this;
        while ( ! $c->getCategoryGroup() && $c->getParent()) {
            $c = $c->getParent();
        }
        return $c->getCategoryGroup();
    }
}
