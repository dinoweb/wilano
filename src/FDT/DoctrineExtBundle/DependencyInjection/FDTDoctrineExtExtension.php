<?php

namespace FDT\DoctrineExtBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;

class FDTDoctrineExtExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
    	$processor = new Processor();
        $configuration = new Configuration(true);
        $config = $processor->processConfiguration($configuration, $configs);
                                    	    	
    	
    	$loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
    	$loader->load('services.yml');
    	
    	$container->setParameter('node_listener.class', $config['NestedSet']['nested_set_listener']);
    	$container->setParameter('tree_manager.class', $config['NestedSet']['tree_manager']);
    	    	    	
    }
    
    
    public function getAlias()
    {
    	return 'fdt_doctrine_ext';
    }
    
    		

}

