<?php

namespace FDT\DoctrineExtBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('fdt_doctrine_ext');

        $this->addListenerSection($rootNode);

        return $treeBuilder;
    }

    private function addListenerSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('NestedSet')
                ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('nested_set_listener')
                            ->cannotBeEmpty()
                            ->defaultValue('FDT\\doctrineExtensions\\NestedSet\\NestedSetListener')
                        ->end()
                    ->end()
                    ->children()
                        ->scalarNode('tree_manager')
                            ->cannotBeEmpty()
                            ->defaultValue('FDT\\doctrineExtensions\\NestedSet\\TreeManager')
                        ->end()
                    ->end()
                ->end()
            ->end();
            
    }
    
}