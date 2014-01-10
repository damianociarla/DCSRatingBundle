<?php

namespace DCS\RatingBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use DCS\RatingBundle\DependencyInjection\Compiler\TwigFormPass;

class DCSRatingBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new TwigFormPass());
    }
}
