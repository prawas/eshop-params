<?php

namespace Onest\EshopParamsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Product;

/**
 * @ORM\Entity
 */
class Parameter
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Onest\EshopParamsBundle\Entity\ParameterClass")
     */
    private $class;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $value_string;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $value_int;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $value_float;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $value_array;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="parameters")
     */
    private $product;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $value_bool;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClass(): ?ParameterClass
    {
        return $this->class;
    }

    public function setClass(?ParameterClass $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function getValueString(): ?string
    {
        return $this->value_string;
    }

    public function setValueString(?string $value_string): self
    {
        $this->value_string = $value_string;

        return $this;
    }

    public function getValueInt(): ?int
    {
        return $this->value_int;
    }

    public function setValueInt(?int $value_int): self
    {
        $this->value_int = $value_int;

        return $this;
    }

    public function getValueFloat(): ?float
    {
        return $this->value_float;
    }

    public function setValueFloat(?float $value_float): self
    {
        $this->value_float = $value_float;

        return $this;
    }

    public function getValueArray(): ?array
    {
        return $this->value_array;
    }

    public function setValueArray(?array $value_array): self
    {
        $this->value_array = $value_array;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getValueBool(): ?bool
    {
        return $this->value_bool;
    }

    public function setValueBool(?bool $value_bool): self
    {
        $this->value_bool = $value_bool;

        return $this;
    }

    public function isEmpty(): bool
    {
        return $this->value_string === null && $this->value_int === null && $this->value_float === null && $this->value_bool === null;
    }

    public function getValue()
    {
        if ( ! $this->getClass() ) {
            return $this->string_value;
        }

        switch ($this->getClass()->getType()) {
            case 'array_string':
            case 'string':
                return $this->value_string;
            case 'array_int':
            case 'int':
                return $this->value_int;
            case 'array_float':
            case 'float':
                return $this->value_float;
            case 'bool':
                return $this->value_bool;
            case 'color':
                return $this->value_string;
            default:
                return $this->value_string;
        }
    }
}
