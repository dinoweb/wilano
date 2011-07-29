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
        
        $configTextAreaTraduzione = new Config ();
        $configTextAreaTraduzione->setOrdine (15);
        $configTextAreaTraduzione->addAttributo($manager->merge($this->getReference('attributo.textAreaTraduzione')));       	
        $manager->persist($configTextAreaTraduzione);
        
        $configTextTraduzione = new Config ();
        $configTextTraduzione->setOrdine (17);
        $configTextTraduzione->addAttributo($manager->merge($this->getReference('attributo.textTranslation')));       	
        $manager->persist($configTextTraduzione);
        
        
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
        
        $configNazione = new Config ();
        $configNazione->setOrdine (50);
        $configNazione->addAttributo($manager->merge($this->getReference('attributo.nazione')));       	
        $manager->persist($configNazione);
        
        $manager->flush();
               	
       	$this->addReference('config.peso', $configPeso);
       	$this->addReference('config.descrizione', $configDescrizione);
       	$this->addReference('config.length', $configLength);
       	$this->addReference('config.larghezza', $configLarghezza);
       	$this->addReference('config.nazione', $configNazione);
       	$this->addReference('config.textAreaTraduzione', $configTextAreaTraduzione);
       	$this->addReference('config.textTranslation', $configTextTraduzione);
    }
    
    public function getOrder()
    {
        return 3; // the order in which fixtures will be loaded
    }

 
}