<?php

namespace Onest\EshopParamsBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sonata\Form\Type\CollectionType;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Form\Type\ModelType;

use Onest\EshopParamsBundle\Entity\ParameterClass;

final class CategoryGroupAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Группа категорий')
                ->add('name', TextType::class, [
                    'label' => 'Название',
                ])
                ->add('categories', ModelType::class, [
                    'label' => 'Категории',
                    'multiple' => true,
                    'property' => 'cyrillicFullPath',
                    'required' => false,
                ])
                ->add('parameters', CollectionType::class, [
                    'label' => 'Параметры',
                    'required' => false,
                    'type_options' => [
                        'delete' => true,
                    ]
                ], [
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'position',
                ])
            ->end()
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', null, ['label' => 'Название'])
            ->addIdentifier('categories', null, ['label' => 'Категории'])
            ->addIdentifier('parameters', null, ['label' => 'Параметры'])
        ;
    }

    protected function updateCategories($object)
    {
        foreach ($object->getCategories() as $cat) {
            $cat->setCategoryGroup($object);
        }
    }

    protected function updateParameters($object)
    {
        $em = $this->getModelManager()->getEntityManager($this->getClass());
        $params = $em->getRepository(ParameterClass::class)->findBy(['categoryGroup' => $object]);

        foreach ($params as $par) {
            $par->setCategoryGroup(null);
        }

        foreach ($object->getParameters() as $par) {
            $par->setCategoryGroup($object);
        }
    }

    public function prePersist($object)
    {
        $this->updateCategories($object);
        $this->updateParameters($object);
    }

    public function preUpdate($object)
    {
        $this->updateCategories($object);
        $this->updateParameters($object);
    }
}
