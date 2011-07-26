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
    }
    
    
    public function load($manager)
    {
        $gioielli = new Prodotti ();
       	$gioielli->setName ('Gioielli name');
       	$gioielli->setUniqueName ('Gioielli');
       	$gioielli->addAttributi($manager->merge($this->getReference('config.larghezza'))); 
       	$gioielli->addAttributi($manager->merge($this->getReference('config.descrizione')));
       	$gioielli->addAttributi($manager->merge($this->getReference('config.nazione'))); 
       	
       	$orecchini = new Prodotti ();
       	$orecchini->setName ('Orecchini name');
       	$orecchini->setUniqueName ('Orecchini');
       	$orecchini->addAttributi($manager->merge($this->getReference('config.length')));
       	
       	$nodeGioielli = $this->getTreeManager($manager)->getNode ($gioielli);
              	       	
       	$nodeGioielli->addChild ($orecchini);
       	
       	$orecchiniChild = new Prodotti ();
       	$orecchiniChild->setName ('Sotto orecchini');
       	$orecchiniChild->setUniqueName ('Orecchini figli');
       	$orecchiniChild->addAttributi($manager->merge($this->getReference('config.peso')));
       	       	
       	$nodeOrecchini = $this->getTreeManager($manager)->getNode ($orecchini);
       	
       	$nodeOrecchini->addChild ($orecchiniChild);
        
        $manager->persist($orecchiniChild);
        $manager->flush();
        
        //print_r ($orecchiniChild->getAttributi()->getKeys());
                       	
       	$this->addReference('tipologia.gioielli', $gioielli);
    }
    
    public function getOrder()
    {
        return 4; // the order in which fixtures will be loaded
    }

 
}