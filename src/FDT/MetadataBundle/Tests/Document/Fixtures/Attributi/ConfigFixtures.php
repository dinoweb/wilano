<?php

namespace FDT\MetadataBundle\Tests\Document\Fixtures\Attributi;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use FDT\MetadataBundle\Document\Attributi\Config;


class ConfigFixtures extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    
    public function load($manager)
    {
        $configPeso = new Config ();
        $configPeso->addAttributo($manager->merge($this->getReference('attributo.peso')));       	
        $manager->persist($configPeso);
        
        
        $configDescrizione = new Config ();
        $configDescrizione->addAttributo($manager->merge($this->getReference('attributo.descrizione')));       	
        $manager->persist($configDescrizione);
        
        $configLength = new Config ();
        $configLength->addAttributo($manager->merge($this->getReference('attributo.length')));       	
        $manager->persist($configLength);
        
        $manager->flush();
               	
       	$this->addReference('config.peso', $configPeso);
       	$this->addReference('config.descrizione', $configDescrizione);
       	$this->addReference('config.length', $configLength);
    }
    
    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }

 
}