<?php

namespace FDT\MetadataBundle\Tests\Document\Fixtures\Attributi;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use FDT\doctrineExtensions\NestedSet\TreeManager;

use FDT\MetadataBundle\Document\Tipologie\Prodotti;


class TipologiaFixtures extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{

    public function getTreeManager($manager)
    {
        return new TreeManager ($manager);
        $this->container = $container;
    }
    
    
    public function load($manager)
    {
        $gioielli = new Prodotti ();
       	$gioielli->setName ('Gioielli name');
       	$gioielli->setUniqueName ('Gioielli');
       	$gioielli->addMetadata($manager->merge($this->getReference('config.peso'))); 
       	$gioielli->addMetadata($manager->merge($this->getReference('config.descrizione'))); 
       	
       	$orecchini = new Prodotti ();
       	$orecchini->setName ('Orecchini name');
       	$orecchini->setUniqueName ('Orecchini');
       	$orecchini->addMetadata($manager->merge($this->getReference('config.length')));
       	
       	$nodeGioielli = $this->getTreeManager($manager)->getNode ($gioielli);
              	       	
       	$nodeGioielli->addChild ($orecchini);
        
        $manager->persist($orecchini);
        $manager->flush();
               	
       	$this->addReference('tipologia.gioielli', $gioielli);
    }
    
    public function getOrder()
    {
        return 3; // the order in which fixtures will be loaded
    }

 
}