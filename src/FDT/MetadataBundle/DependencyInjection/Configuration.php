<?php

namespace FDT\MetadataBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('fdt_metadata');

        $this->addAttribtutoSaverSection($rootNode);

        return $treeBuilder;
    }

    private function addAttribtutoSaverSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('document_saver')
                ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('document_saver_class')
                            ->cannotBeEmpty()
                            ->defaultValue('FDT\\MetadataBundle\\Services\\DocumentSaver')
                        ->end()
                    ->end()
                ->end()
            ->end();
            
    }
    
}