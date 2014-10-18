<?php

namespace DCS\RatingBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class DCSRatingExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        if (!in_array(strtolower($config['db_driver']), array('orm'))) {
            throw new \InvalidArgumentException(sprintf('Invalid db driver "%s".', $config['db_driver']));
        }

        $loader->load(sprintf('%s.xml', $config['db_driver']));

        $container->setParameter('dcs_rating.base_security_role', $config['base_security_role']);
        $container->setParameter('dcs_rating.base_path_to_redirect', $config['base_path_to_redirect']);
        $container->setParameter('dcs_rating.unique_vote', $config['unique_vote']);
        $container->setParameter('dcs_rating.max_value', $config['max_value']);
        $container->setParameter('dcs_rating.model.rating.class', $config['model']['rating']);
        $container->setParameter('dcs_rating.model.vote.class', $config['model']['vote']);

        $container->setAlias('dcs_rating.manager.rating', $config['service']['manager']['rating']);
        $container->setAlias('dcs_rating.manager.vote', $config['service']['manager']['vote']);

        $loader->load('event.xml');
        $loader->load('twig.xml');
    }
}
