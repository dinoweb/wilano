<?php

namespace FDT\AdminBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;

class FDTAdminExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
    	$processor = new Processor();
        $configuration = new Configuration(true);
        $config = $processor->processConfiguration($configuration, $configs);
                            	    	
    	
    	$loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
    	$loader->load('services.yml');
    	
    	$container->setParameter('manage_menu.config', $config['menuConfig']);
    	    	    	
    	$container->setParameter('bundles_config.config', $config['configuration']);
    	
    }
    
    
    public function getAlias()
    {
    	return 'fdt_admin';
    }
    
    		

}

