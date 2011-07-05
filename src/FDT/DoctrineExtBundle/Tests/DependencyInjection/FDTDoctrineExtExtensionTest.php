<?php

namespace FDT\DoctrineExtBundle\Tests\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;

use FDT\DoctrineExtBundle\DependencyInjection\FDTDoctrineExtExtension;
use FDT\DoctrineExtBundle\DependencyInjection\Configuration;


class FDTDoctrineExtExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testConfigLoad()
    {
        $extension = new FDTDoctrineExtExtension();

        $configs = array();
        $processor = new Processor();
        $configuration = new Configuration(true);
        $config = $processor->processConfiguration($configuration, $configs);
        $extension->load(array($config), $container = new ContainerBuilder());

        $this->assertTrue($container->hasParameter('node_listener.class'));
        $this->assertEquals($container->getParameter('node_listener.class'), 'FDT\doctrineExtensions\NestedSet\NestedSetListener');
        $this->assertTrue($container->getDefinition('node_listener')->hasTag('doctrine.odm.mongodb.default_event_subscriber'));
        
        $this->assertTrue($container->hasParameter('tree_manager.class'));
        $this->assertEquals($container->getParameter('tree_manager.class'), 'FDT\doctrineExtensions\NestedSet\TreeManager');
        
    
    }

}