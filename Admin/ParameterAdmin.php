<?php

namespace Onest\EshopParamsBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Sonata\Form\Type\CollectionType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Doctrine\ORM\EntityManagerInterface;

use Onest\EshopParamsBundle\Entity\ParameterClass;

final class ParameterAdmin extends AbstractAdmin
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct($code, $class, $baseControllerName, EntityManagerInterface $em)
    {
        parent::__construct($code, $class, $baseControllerName);

        $this->em = $em;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $subject = $this->getSubject();
        $class = $subject ? $subject->getClass() : null;
        $product = $subject ? $subject->getProduct() : null;

        $formMapper
            ->add('class', ModelType::class, [
                'label' => 'Параметр',
                'btn_add' => false,
                'btn_delete' => false,
                'choices' => $class ? [ $class->getLabel() => $class ] : ($product ? $product->getParametersClasses() : []),
                // 'choices' => $product ? $product->getParametersClasses() : [],
            ])
        ;

        if ( ! $class) {
            return;
        }

        if ($class->getMultiple() && in_array($class->getType(), ['array_string', 'array_int', 'array_float'])) {
            $formMapper
            ->add('value_array', ChoiceType::class, [
                'label' => 'Значение',
                'required' => false,
                'choices' => array_combine($class->getData(), $class->getData()),
                'multiple' => true,
                'expanded' => true,
            ]);
            return;
        }

        switch ($class->getType()) {
            case 'array_string':
                $formMapper
                    ->add('value_string', ChoiceType::class, [
                        'label' => 'Значение',
                        'required' => false,
                        'choices' => array_combine($class->getData(), $class->getData()),
                    ])
                ;
            break;
            case 'string':
                $formMapper
                    ->add('value_string', TextType::class, [
                        'label' => 'Значение',
                        'required' => false,
                    ])
                ;
            break;
            case 'array_int':
                $formMapper
                    ->add('value_int', ChoiceType::class, [
                        'label' => 'Значение',
                        'required' => false,
                        'choices' => array_combine($class->getData(), $class->getData()),
                    ])
                ;
            break;
            case 'int':
                $formMapper
                    ->add('value_int', NumberType::class, [
                        'label' => 'Значение',
                        'required' => false,
                    ])
                ;
            break;
            case 'array_float':
                $formMapper
                    ->add('value_float', ChoiceType::class, [
                        'label' => 'Значение',
                        'required' => false,
                        'choices' => array_combine($class->getData(), $class->getData()),
                    ])
                ;
            break;
            case 'float':
                $formMapper
                    ->add('value_float', NumberType::class, [
                        'label' => 'Значение',
                        'required' => false,
                    ])
                ;
            break;
            case 'bool':
                $formMapper
                    ->add('value_bool', CheckboxType::class, [
                        'label' => 'Значение',
                        'required' => false,
                    ])
                ;
            break;
            case 'color':
                $formMapper
                    ->add('value_string', TextType::class, [
                        'label' => 'Значение',
                        'required' => false,
                    ])
                ;
            break;
        }
    }

    protected function configureListFields(ListMapper $listMapper)
    {
    }
}
