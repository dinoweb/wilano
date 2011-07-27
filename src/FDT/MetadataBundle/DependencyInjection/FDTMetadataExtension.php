<?php

namespace FDT\MetadataBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;

class FDTMetadataExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
    	$processor = new Processor();
        $configuration = new Configuration(true);
        $config = $processor->processConfiguration($configuration, $configs);
                                    	    	
    	
    	$loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
    	$loader->load('services.yml');
    	
    	//DOCUMENT SAVER PARAMS
    	$container->setParameter('document_saver.class', $config['document_saver']['document_saver_class']);
    	
    	//FORM BUILDER PARAMS
    	$container->setParameter('form_builder_director_class', $config['form_builder_director']['form_builder_director_class']);
    	$container->setParameter('languages', $config['form_builder_director']['languages']);
    	$container->setParameter('form_builder_class', $config['form_builder']['form_builder_class']);
    	$container->setParameter('formClasses', $config['form_builder']['formClasses']);
    	    	    	
    }
    
    
    public function getAlias()
    {
    	return 'fdt_metadata';
    }
    
    		

}

