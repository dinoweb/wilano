<?php

namespace FDT\MetadataBundle\Tests\Document\Fixtures\Attributi;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use FDT\MetadataBundle\Document\Attributi\Attributo;


class AttributiFixtures extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    
    public function load($manager)
    {
        $attributo = new Attributo ();
       	$attributo->setName ('Peso visibile');
       	$attributo->setUniqueName ('Peso');
       	$attributo->setTipo ('weight');
       	
        $manager->persist($attributo);
       	
       	$this->addReference('attributo.peso', $attributo);
       	
       	$attributo2 = new Attributo ();
       	$attributo2->setName ('Descrizione visibile');
       	$attributo2->setUniqueName ('Descrizione');
       	$attributo2->setTipo ('textarea');
       	
        $manager->persist($attributo2);
        
        $this->addReference('attributo.descrizione', $attributo2);
        
        $attributo3 = new Attributo ();
       	$attributo3->setName ('Lunghezza visibile');
       	$attributo3->setUniqueName ('Lunghezza');
       	$attributo3->setTipo ('length');
       	
        $manager->persist($attributo3);
        
        $this->addReference('attributo.length', $attributo3);
        
        
        $manager->flush();
       	
       	
    }
    
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }

 
}