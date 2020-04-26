<?php

namespace Onest\EshopParamsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Onest\EshopParamsBundle\DependencyInjection\EshopParamsExtension;

class EshopParamsBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new EshopParamsExtension();
    }
}
