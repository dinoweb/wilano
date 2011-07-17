<?php

namespace FDT\MetadataBundle\Tests\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;

use FDT\MetadataBundle\DependencyInjection\FDTMetadataExtension;
use FDT\MetadataBundle\DependencyInjection\Configuration;


class FDTMetadataExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testConfigLoad()
    {
        $extension = new FDTMetadataExtension();

        $configs = array();
        $processor = new Processor();
        $configuration = new Configuration(true);
        $config = $processor->processConfiguration($configuration, $configs);
        $extension->load(array($config), $container = new ContainerBuilder());

        $this->assertTrue($container->hasParameter('attributo_saver.class'));
        $this->assertEquals($container->getParameter('attributo_saver.class'), 'FDT\MetadataBundle\Services\AttributoSaver');
        
        
    
    }

}