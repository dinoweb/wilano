<?php

namespace FDT\DoctrineExtBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use FDT\DoctrineExtBundle\DependencyInjection\FDTDoctrineExtExtension;

class FDTDoctrineExtExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testConfigLoad()
    {
        $extension = new FDTDoctrineExtExtension();

        $config = array();
        $extension->load(array($config), $container = new ContainerBuilder());

        $this->assertTrue($container->hasDefinition('security.access.method_interceptor'));
        $this->assertTrue($container->hasDefinition('security.extra.controller_listener'));
        $this->assertFalse($container->getParameter('security.extra.secure_all_services'));
        $this->assertFalse($container->getDefinition('security.extra.iddqd_voter')->hasTag('security.voter'));
    }

}