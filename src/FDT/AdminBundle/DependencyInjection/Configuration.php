<?php

namespace FDT\AdminBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;


class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('fdt_admin');

        $this->addPathSection($rootNode);
        $this->addMenuSection($rootNode);

        return $treeBuilder;
    }

    private function addPathSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('pathConfig')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('paths')
                            ->requiresAtLeastOneElement ()
                            ->prototype('variable')->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
            
            /*
$rootNode
            ->children()
                ->arrayNode('pathConfig')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->arrayNode('paths')
                            ->requiresAtLeastOneElement ()
                            ->children()
                                ->arrayNode('0')
                                    ->children()
                                        ->scalarNode('name')->end()
                                        ->scalarNode('path')->end()
                                    ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
*/
    }
    
 
    private function addMenuSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('menuConfig')
                    ->requiresAtLeastOneElement()
                    ->children()
                        ->arrayNode('metadata')
                            ->requiresAtLeastOneElement ()
                            ->prototype('variable')->end()
                        ->end()
                        ->arrayNode('parties')
                            ->requiresAtLeastOneElement ()
                            ->prototype('variable')->end()
                        ->end()
                    ->end()
                    ->children()
                        ->arrayNode('contents')
                            ->requiresAtLeastOneElement ()
                            ->prototype('variable')->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}