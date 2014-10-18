<?php

namespace DCS\RatingBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('dcs_rating');

        $rootNode
            ->children()
                ->scalarNode('db_driver')->isRequired()->end()
                ->scalarNode('base_security_role')->defaultValue('IS_AUTHENTICATED_FULLY')->end()
                ->scalarNode('base_path_to_redirect')->defaultValue('/')->end()
                ->booleanNode('unique_vote')->defaultTrue()->end()
                ->integerNode('max_value')->cannotBeEmpty()->defaultValue(5)->end()
            ->end()
            ->append($this->buildModelConfiguration())
            ->append($this->buildServiceConfiguration())
        ;

        return $treeBuilder;
    }

    private function buildModelConfiguration()
    {
        $builder = new TreeBuilder();
        $node = $builder->root('model');

        $node
            ->isRequired()
            ->children()
                ->scalarNode('rating')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('vote')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
            ->end()
        ;

        return $node;
    }

    private function buildServiceConfiguration()
    {
        $builder = new TreeBuilder();
        $node = $builder->root('service');

        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('manager')->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('rating')->cannotBeEmpty()->defaultValue('dcs_rating.manager.rating.default')->end()
                        ->scalarNode('vote')->cannotBeEmpty()->defaultValue('dcs_rating.manager.vote.default')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $node;
    }
}
