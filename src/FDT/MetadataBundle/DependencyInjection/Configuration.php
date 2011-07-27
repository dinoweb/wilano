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

        $this->addDocumentSaverSection($rootNode);
        $this->addFormBuilderDirectorSection($rootNode);
        $this->addFormBuilderSection($rootNode);

        return $treeBuilder;
    }

    private function addDocumentSaverSection(ArrayNodeDefinition $rootNode)
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
    
    private function addFormBuilderSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('form_builder')
                ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('form_builder_class')
                            ->cannotBeEmpty()
                            ->defaultValue('FDT\\MetadataBundle\\Utilities\\Contenuti\\FormBuilderContenuti')
                        ->end()
                    ->end()
                    ->children ()
                        ->arrayNode('formClasses')
                        ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('contenuto')
                                    ->cannotBeEmpty()
                                    ->defaultValue('Contenuto')
                                ->end()
                            ->end()
                            ->children()
                                ->scalarNode('attributi')
                                    ->cannotBeEmpty()
                                    ->defaultValue('Attributi')
                                ->end()
                            ->end()
                            ->children()
                                ->scalarNode('immagini')
                                    ->cannotBeEmpty()
                                    ->defaultValue('Immagini')
                                ->end()
                            ->end()
                            ->children()
                                ->scalarNode('testi')
                                    ->cannotBeEmpty()
                                    ->defaultValue('Testi')
                                ->end()
                            ->end()
                            ->children()
                                ->scalarNode('documenti')
                                    ->cannotBeEmpty()
                                    ->defaultValue('Documenti')
                                ->end()
                            ->end()
                            ->children()
                                ->scalarNode('video')
                                    ->cannotBeEmpty()
                                    ->defaultValue('Video')
                                ->end()
                            ->end()
                            ->children()
                                ->scalarNode('categorie')
                                    ->cannotBeEmpty()
                                    ->defaultValue('Categorie')
                                ->end()
                            ->end()
                            ->children()
                                ->scalarNode('metadata')
                                    ->cannotBeEmpty()
                                    ->defaultValue('Metadata')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
            
    }
    
    private function addFormBuilderDirectorSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('form_builder_director')
                ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('form_builder_director_class')
                            ->cannotBeEmpty()
                            ->defaultValue('FDT\\MetadataBundle\\Services\\FormBuilderDirector')
                        ->end()
                    ->end()
                    ->children ()
                        ->arrayNode('languages')
                        ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('it_it')
                                    ->cannotBeEmpty()
                                    ->defaultValue('Italiano')
                                ->end()
                            ->end()
                            ->children()
                                ->scalarNode('en_en')
                                    ->cannotBeEmpty()
                                    ->defaultValue('Inglese')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
            
    }
    
}