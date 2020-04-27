## Описание

Бандл создает группы категорий,
к каждой группе категорий можно прописать типы параметров. 

![группы категорий](https://prawas.s3.amazonaws.com/params-category-groups.png "Группы категорий")

![параметры групп категорий](https://prawas.s3.amazonaws.com/params-category-group.png "Параметры групп категорий")

После чего, в товаре можно прописывать заданные параметры:

![параметры товара](https://prawas.s3.amazonaws.com/params-product.png "Параметры товара")

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

## Настройка и зависимости

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
                'help' => 'Если параметры определены для категории, но список отсутствует, просто сохраните товар.',
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

### Testing

    bin/console doctrine:fixtures:load --env=test

    bin/phpunit vendor/prawas/eshop-params-bundle

### Пример создания формы фильтров для фронтэнда

    /**
     * Получить группу категории с учетом родительских.
     * Если категория привязана к группе, то все ее дочерние категории будут иметь ту же группу,
     * если они явно не привязаны к другой группе.
     * @var $categoryGroup CategoryGroup
     */
    $categoryGroup = $category->searchCategoryGroupBasedOnParents();

    /**
     * @var $params Collection|ParameterClass[]
     */
    $params = $categoryGroup->getParameters();

    $builder = $this->createFormBuilder();

    foreach ($params as $param) {
        switch ($param->getType()) {
            case 'array_string':
            case 'array_int':
            case 'array_float':
                $builder->add('param_' . $param->getId(), ChoiceType::class, [
                    'label' => $param->getLabel(),
                    'choices' => array_combine($param->getData(), $param->getData()),
                    'required' => false,
                    'placeholder' => 'Не имеет значения',
                ]);
            break;
            case 'string':
                $builder->add('param_' . $param->getId(), TextType::class, [
                    'label' => $param->getLabel(),
                    'required' => false,
                    'placeholder' => 'Не имеет значения',
                ]);
            break;
            case 'int':
            case 'float':
                $builder->add('param_' . $param->getId(), IntervalType::class, [
                    'label' => $param->getLabel(),
                    'required' => false,
                ]);
            break;
            case 'bool':
                $builder->add('param_' . $param->getId(), ChoiceType::class, [
                    'label' => $param->getLabel(),
                    'required' => false,
                    'choices' => [
                        'Да' => 1,
                        'Нет' => 2,
                    ],
                    'placeholder' => 'Не имеет значения',
                    'expanded' => true,
                ]);
            break;
            case 'color':
                $builder->add('param_' . $param->getId(), YandexColorType::class, [
                    'label' => $param->getLabel(),
                    'required' => false,
                    'placeholder' => 'Не имеет значения',
                ]);
            break;
            default:
                $builder->add('param_' . $param->getId(), TextType::class, [
                    'label' => $param->getName(),
                ]);
            break;
        }
    }

    $form = $builder->getForm();