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
        $configPeso->setOrdine (10);
        $configPeso->addAttributo($manager->merge($this->getReference('attributo.peso')));       	
        $manager->persist($configPeso);
        
        
        $configDescrizione = new Config ();
        $configDescrizione->setOrdine (20);
        $configDescrizione->addAttributo($manager->merge($this->getReference('attributo.descrizione')));       	
        $manager->persist($configDescrizione);
        
        $configLength = new Config ();
        $configLength->setOrdine (30);
        $configLength->addAttributo($manager->merge($this->getReference('attributo.length')));       	
        $manager->persist($configLength);
        
        $configLarghezza = new Config ();
        $configLarghezza->setOrdine (40);
        $configLarghezza->addAttributo($manager->merge($this->getReference('attributo.larghezza')));       	
        $manager->persist($configLarghezza);
        
        $manager->flush();
               	
       	$this->addReference('config.peso', $configPeso);
       	$this->addReference('config.descrizione', $configDescrizione);
       	$this->addReference('config.length', $configLength);
       	$this->addReference('config.larghezza', $configLarghezza);
    }
    
    public function getOrder()
    {
        return 3; // the order in which fixtures will be loaded
    }

 
}