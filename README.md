## TODO

- Форма фильтров ???
- Тесты вынести в бандл

## Описание

Бандл создает группы категорий,
к каждой группе категорий можно прописать типы параметров. 

![параметры групп категорий](https://prawas.s3.amazonaws.com/params-category-group.png "Параметры групп категорий")

## Зависимости

В проекте должны быть определены сущности:

- App\Entity\Product extends \Onest\EshopParamsBundle\Entity\Product
- App\Entity\Category extends \Onest\EshopParamsBundle\Entity\Category

В товар нужно добавить управление параметрами:

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
