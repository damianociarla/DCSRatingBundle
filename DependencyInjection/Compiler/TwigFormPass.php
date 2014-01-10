<?php

namespace DCS\RatingBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class TwigFormPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasParameter('twig.form.resources')) {
            return;
        }

        $container->setParameter('twig.form.resources', array_merge(
            array('DCSRatingBundle:Form:rating.html.twig'),
            $container->getParameter('twig.form.resources')
        ));
    }
}