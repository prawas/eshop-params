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
    php bin/console assets:install
    php bin/console cache:clear
    php bin/console doctrine:schema:update --force

### bundles.php

    return [
        ...
        Onest\EshopParamsBundle\EshopParamsBundle::class => ['all' => true],
    ];
