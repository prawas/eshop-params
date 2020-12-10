<?php

namespace Onest\EshopParamsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class ParameterClass
{
    const TYPE_CHOICES = [
        'Массив строк' => 'array_string',
        'Массив числовых целых значений' => 'array_int' ,
        'Массив числовых дробных значений' => 'array_float' ,
        'Целое число' => 'int',
        'Дробное число' => 'float',
        'Логическое (да / нет)' => 'bool',
        'Строка' => 'string',
        'Цвет' => 'color',
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $data = [];

    /**
     * @ORM\ManyToOne(targetEntity="Onest\EshopParamsBundle\Entity\CategoryGroup", inversedBy="parameters")
     */
    private $categoryGroup;

    /**
     * @ORM\Column(type="boolean")
     */
    private $multiple = false;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $suffix;

    /**
     * @ORM\OneToMany(targetEntity="Onest\EshopParamsBundle\Entity\Parameter", mappedBy="class", cascade={"persist","remove"})
     */
    private $parameters;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $external_id;

    public function __toString(): string
    {
        return $this->getLabel();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getData(): ?array
    {
        return $this->data;
    }

    public function setData(?array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getCategoryGroup(): ?CategoryGroup
    {
        return $this->categoryGroup;
    }

    public function setCategoryGroup(?CategoryGroup $categoryGroup): self
    {
        $this->categoryGroup = $categoryGroup;

        return $this;
    }

    public function getMultiple(): ?bool
    {
        return $this->multiple;
    }

    public function setMultiple(bool $multiple): self
    {
        $this->multiple = $multiple;

        return $this;
    }

    public function getSuffix(): ?string
    {
        return $this->suffix;
    }

    public function setSuffix(?string $suffix): self
    {
        $this->suffix = $suffix;

        return $this;
    }

    public function getLabel(): string
    {
        return $this->name . (( ! empty($this->suffix)) ? ', ' . $this->suffix : '');
    }

    public function getExternalId(): ?int
    {
        return $this->external_id;
    }

    public function setExternalId(?int $external_id): self
    {
        $this->external_id = $external_id;

        return $this;
    }
}
