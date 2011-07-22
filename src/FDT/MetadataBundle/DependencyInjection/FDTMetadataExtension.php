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
    	
    	$container->setParameter('document_saver.class', $config['document_saver']['document_saver_class']);
    	    	    	
    }
    
    
    public function getAlias()
    {
    	return 'fdt_metadata';
    }
    
    		

}

