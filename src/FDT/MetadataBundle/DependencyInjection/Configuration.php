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
        $this->addAttributiTypeSection($rootNode);
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
    
    private function addAttributiTypeSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('attributi_type')
                ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('attributi_type_class')
                            ->cannotBeEmpty()
                            ->defaultValue('FDT\\MetadataBundle\\Services\\AttributiTypeManager')
                        ->end()
                    ->end()
                    ->children ()
                        ->arrayNode('attributi')
                        ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('text')
                                ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('name')
                                            ->cannotBeEmpty()
                                            ->defaultValue('Text')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->scalarNode('formType')
                                            ->cannotBeEmpty()
                                            ->defaultValue('FDT\\MetadataBundle\\Form\\Type\\Attributi\\TextType')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->booleanNode('hasTranslation')
                                            ->defaultValue(false)
                                        ->end()
                                    ->end()
                                ->end()
                                ->arrayNode('textTranslation')
                                ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('name')
                                            ->cannotBeEmpty()
                                            ->defaultValue('Text con Traduzione')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->scalarNode('formType')
                                            ->cannotBeEmpty()
                                            ->defaultValue('FDT\\MetadataBundle\\Form\\Type\\Attributi\\TextType')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->booleanNode('hasTranslation')
                                            ->defaultValue(true)
                                        ->end()
                                    ->end()
                                ->end()
                                ->arrayNode('textarea')
                                ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('name')
                                            ->cannotBeEmpty()
                                            ->defaultValue('Textarea')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->scalarNode('formType')
                                            ->cannotBeEmpty()
                                            ->defaultValue('FDT\\MetadataBundle\\Form\\Type\\Attributi\\TextareaType')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->booleanNode('hasTranslation')
                                            ->defaultValue(false)
                                        ->end()
                                    ->end()
                                ->end()
                                ->arrayNode('textareaTranslation')
                                ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('name')
                                            ->cannotBeEmpty()
                                            ->defaultValue('Text Area Translation')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->scalarNode('formType')
                                            ->cannotBeEmpty()
                                            ->defaultValue('FDT\\MetadataBundle\\Form\\Type\\Attributi\\TextareaType')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->booleanNode('hasTranslation')
                                            ->defaultValue(true)
                                        ->end()
                                    ->end()
                                ->end()
                                ->arrayNode('textareaHtml')
                                ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('name')
                                            ->cannotBeEmpty()
                                            ->defaultValue('Text Area Html')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->scalarNode('formType')
                                            ->cannotBeEmpty()
                                            ->defaultValue('FDT\\MetadataBundle\\Form\\Type\\Attributi\\TextareaHtmlType')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->booleanNode('hasTranslation')
                                            ->defaultValue(false)
                                        ->end()
                                    ->end()
                                ->end()
                                ->arrayNode('textareaHtmlTranslation')
                                ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('name')
                                            ->cannotBeEmpty()
                                            ->defaultValue('Text Area Html Translation')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->scalarNode('formType')
                                            ->cannotBeEmpty()
                                            ->defaultValue('FDT\\MetadataBundle\\Form\\Type\\Attributi\\TextareaHtmlType')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->booleanNode('hasTranslation')
                                            ->defaultValue(true)
                                        ->end()
                                    ->end()
                                ->end()
                                ->arrayNode('number')
                                ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('name')
                                            ->cannotBeEmpty()
                                            ->defaultValue('Numero')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->scalarNode('formType')
                                            ->cannotBeEmpty()
                                            ->defaultValue('FDT\\MetadataBundle\\Form\\Type\\Attributi\\NumberType')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->booleanNode('hasTranslation')
                                            ->defaultValue(false)
                                        ->end()
                                    ->end()
                                ->end()
                                ->arrayNode('decimal')
                                ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('name')
                                            ->cannotBeEmpty()
                                            ->defaultValue('Decimale')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->scalarNode('formType')
                                            ->cannotBeEmpty()
                                            ->defaultValue('FDT\\MetadataBundle\\Form\\Type\\Attributi\\DecimalType')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->booleanNode('hasTranslation')
                                            ->defaultValue(false)
                                        ->end()
                                    ->end()
                                ->end()
                                ->arrayNode('boolean')
                                ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('name')
                                            ->cannotBeEmpty()
                                            ->defaultValue('Vero o Falso')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->scalarNode('formType')
                                            ->cannotBeEmpty()
                                            ->defaultValue('FDT\\MetadataBundle\\Form\\Type\\Attributi\\BooleanType')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->booleanNode('hasTranslation')
                                            ->defaultValue(false)
                                        ->end()
                                    ->end()
                                ->end()
                                ->arrayNode('data')
                                ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('name')
                                            ->cannotBeEmpty()
                                            ->defaultValue('Data')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->scalarNode('formType')
                                            ->cannotBeEmpty()
                                            ->defaultValue('FDT\\MetadataBundle\\Form\\Type\\Attributi\\DataType')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->booleanNode('hasTranslation')
                                            ->defaultValue(false)
                                        ->end()
                                    ->end()
                                ->end()
                                ->arrayNode('email')
                                ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('name')
                                            ->cannotBeEmpty()
                                            ->defaultValue('E-Mail')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->scalarNode('formType')
                                            ->cannotBeEmpty()
                                            ->defaultValue('FDT\\MetadataBundle\\Form\\Type\\Attributi\\EmailType')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->booleanNode('hasTranslation')
                                            ->defaultValue(false)
                                        ->end()
                                    ->end()
                                ->end()
                                ->arrayNode('immagine')
                                ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('name')
                                            ->cannotBeEmpty()
                                            ->defaultValue('Immagine')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->scalarNode('formType')
                                            ->cannotBeEmpty()
                                            ->defaultValue('FDT\\MetadataBundle\\Form\\Type\\Attributi\\ImmagineType')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->booleanNode('hasTranslation')
                                            ->defaultValue(false)
                                        ->end()
                                    ->end()
                                ->end()
                                ->arrayNode('documento')
                                ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('name')
                                            ->cannotBeEmpty()
                                            ->defaultValue('Documento')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->scalarNode('formType')
                                            ->cannotBeEmpty()
                                            ->defaultValue('FDT\\MetadataBundle\\Form\\Type\\Attributi\\DocumentoType')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->booleanNode('hasTranslation')
                                            ->defaultValue(false)
                                        ->end()
                                    ->end()
                                ->end()
                                ->arrayNode('singleSelect')
                                ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('name')
                                            ->cannotBeEmpty()
                                            ->defaultValue('SingleSelect')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->scalarNode('formType')
                                            ->cannotBeEmpty()
                                            ->defaultValue('FDT\\MetadataBundle\\Form\\Type\\Attributi\\SingleSelectType')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->booleanNode('hasTranslation')
                                            ->defaultValue(false)
                                        ->end()
                                    ->end()
                                ->end()
                                ->arrayNode('multipleSelect')
                                ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('name')
                                            ->cannotBeEmpty()
                                            ->defaultValue('MultipleSelect')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->scalarNode('formType')
                                            ->cannotBeEmpty()
                                            ->defaultValue('FDT\\MetadataBundle\\Form\\Type\\Attributi\\MultipleSelectType')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->booleanNode('hasTranslation')
                                            ->defaultValue(false)
                                        ->end()
                                    ->end()
                                ->end()
                                ->arrayNode('weight')
                                ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('name')
                                            ->cannotBeEmpty()
                                            ->defaultValue('Weight')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->scalarNode('formType')
                                            ->cannotBeEmpty()
                                            ->defaultValue('FDT\\MetadataBundle\\Form\\Type\\Attributi\\WeightType')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->booleanNode('hasTranslation')
                                            ->defaultValue(false)
                                        ->end()
                                    ->end()
                                ->end()
                                ->arrayNode('length')
                                ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('name')
                                            ->cannotBeEmpty()
                                            ->defaultValue('Length')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->scalarNode('formType')
                                            ->cannotBeEmpty()
                                            ->defaultValue('FDT\\MetadataBundle\\Form\\Type\\Attributi\\LengthType')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->booleanNode('hasTranslation')
                                            ->defaultValue(false)
                                        ->end()
                                    ->end()
                                ->end()
                                ->arrayNode('cap')
                                ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('name')
                                            ->cannotBeEmpty()
                                            ->defaultValue('Cap')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->scalarNode('formType')
                                            ->cannotBeEmpty()
                                            ->defaultValue('FDT\\MetadataBundle\\Form\\Type\\Attributi\\CapType')
                                        ->end()
                                    ->end()
                                    ->children()
                                        ->booleanNode('hasTranslation')
                                            ->defaultValue(false)
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
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
                                    ->defaultValue('FDT\\MetadataBundle\\Form\\Type\\ContenutoType')
                                ->end()
                            ->end()
                            ->children()
                                ->scalarNode('attributi')
                                    ->cannotBeEmpty()
                                    ->defaultValue('FDT\\MetadataBundle\\Form\\Type\\AttributiType')
                                ->end()
                            ->end()
                            ->children()
                                ->scalarNode('immagini')
                                    ->cannotBeEmpty()
                                    ->defaultValue('FDT\\MetadataBundle\\Form\\Type\\ImmaginiType')
                                ->end()
                            ->end()
                            ->children()
                                ->scalarNode('testi')
                                    ->cannotBeEmpty()
                                    ->defaultValue('FDT\\MetadataBundle\\Form\\Type\\TestiType')
                                ->end()
                            ->end()
                            ->children()
                                ->scalarNode('documenti')
                                    ->cannotBeEmpty()
                                    ->defaultValue('FDT\\MetadataBundle\\Form\\Type\\DocumentiType')
                                ->end()
                            ->end()
                            ->children()
                                ->scalarNode('video')
                                    ->cannotBeEmpty()
                                    ->defaultValue('FDT\\MetadataBundle\\Form\\Type\\VideoType')
                                ->end()
                            ->end()
                            ->children()
                                ->scalarNode('categorie')
                                    ->cannotBeEmpty()
                                    ->defaultValue('FDT\\MetadataBundle\\Form\\Type\\CategorieType')
                                ->end()
                            ->end()
                            ->children()
                                ->scalarNode('metadata')
                                    ->cannotBeEmpty()
                                    ->defaultValue('FDT\\MetadataBundle\\Form\\Type\\MetadataType')
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
                                ->scalarNode('en_us')
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