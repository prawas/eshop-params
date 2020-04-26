<?php

namespace Onest\EshopParamsBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Sonata\AdminBundle\Form\Type\CollectionType;

use Onest\EshopParamsBundle\Entity\ParameterClass;

final class ParameterClassAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Параметр')
                ->add('name', TextType::class, [
                    'label' => 'Название',
                ])
                ->add('type', ChoiceType::class, [
                    'label' => 'Тип',
                    'choices' => ParameterClass::TYPE_CHOICES,
                ])
                ->add('data', CollectionType::class, [
                    'label' => 'Варианты (только для массивов)',
                    'required' => false,
                    'allow_add' => true,
                ])
                ->add('multiple', CheckboxType::class, [
                    'label' => 'Множественный выбор',
                    'required' => false,
                ])
                ->add('suffix', TextType::class, [
                    'label' => 'Размерность',
                    'required' => false,
                ])
            ->end()
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', null, ['label' => 'Название'])
            ->addIdentifier('type', null, ['label' => 'Тип'])
        ;
    }
}
