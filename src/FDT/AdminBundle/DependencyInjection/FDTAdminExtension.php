<?php

namespace FDT\AdminBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

class FDTAdminExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
    	$config = array();
    	foreach ($configs as $subConfig)
    	{
       	 	$config = array_merge($config, $subConfig);
    	}
    	    	
    	
    	$loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
    	$loader->load('services.yml');
    	
    	$container->setParameter('manage_menu.config', $config);
    	    	
    	$container->setParameter('bundles_config.config', $config['bundlesConfig']);
    	
    }
    
    
    public function getAlias()
    {
    	return 'fdt_admin';
    }
    
    		

}

