## Описание

Бандл создает группы категорий,
к каждой группе категорий можно прописать типы параметров. 

![параметры групп категорий](https://prawas.s3.amazonaws.com/params-category-group.png "Параметры групп категорий")

## Зависимости

Должны быть определены сущности:

App\Entity\Product
App\Entity\Category

В товар нужно добавить управление параметрами:

### TODO: Product extends Onest\EshopParamsBundle\Entity\Product

    class Product
    {
        ...
        /**
         * @ORM\OneToMany(targetEntity="Onest\EshopParamsBundle\Entity\Parameter", mappedBy="product", cascade={"persist"})
         */
        private $parameters;
        ...
    }


    final class ProductAdmin extends AbstractAdmin
    {
        protected function configureFormFields(FormMapper $formMapper)
        {
            ...
            ->add('parameters', CollectionType::class, [
                'required' => false,
                'label' => false,
                'help' => 'Если параметры определены для категории, но список отсутствует, просто   сохраните товар.',
                'type_options' => [
                    'delete' => false,
                ],
                'btn_add' => false,
            ], [
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'position',
            ])
            ...
        }
    }

В категорию — связь с группой категорий:

### TODO: Category extends Onest\EshopParamsBundle\Entity\Category

    class Category
    {
        ...
        /**
         * @ORM\ManyToOne(targetEntity="App\Entity\CategoryGroup", inversedBy="categories")
         */
        private $categoryGroup;
        ...

        public function getCategoryGroupWithParents(): ?CategoryGroup
        {
            $c = $this;
            while ( ! $c->getCategoryGroup() && $c->getParent()) {
                $c = $c->getParent();
            }
            return $c->getCategoryGroup();
        }
    }


## Installation

### composer.json

    {
        "require": {
            "prawas/eshop-params-bundle": "dev-master"
        },
        "repositories": [
            {
                "type": "vcs",
                "url": "https://github.com/prawas/eshop-params"
            }
        ]
    }

### cli

    composer update
    php bin/console cache:clear
    php bin/console doctrine:schema:update --force

### bundles.php

    return [
        ...
        Onest\EshopParamsBundle\EshopParamsBundle::class => ['all' => true],
    ];
