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
       	
       	$attributo2 = new Attributo ();
       	$attributo2->setName ('Descrizione visibile');
       	$attributo2->setUniqueName ('Descrizione');
       	$attributo2->setTipo ('textarea');
       	
        $manager->persist($attributo2);
        
        
        $attributo3 = new Attributo ();
       	$attributo3->setName ('Lunghezza visibile');
       	$attributo3->setUniqueName ('Lunghezza');
       	$attributo3->setTipo ('length');
       	
        $manager->persist($attributo3);
        
        $attributo4 = new Attributo ();
       	$attributo4->setName ('Larghezza visibile');
       	$attributo4->setUniqueName ('Larghezza');
       	$attributo4->setTipo ('number');
       	
        $manager->persist($attributo4);
        
        $manager->flush();
       	
       	$this->addReference('attributo.peso', $attributo);
       	$this->addReference('attributo.descrizione', $attributo2);
       	$this->addReference('attributo.length', $attributo3);
       	$this->addReference('attributo.larghezza', $attributo4);
       	
    }
    
    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }

 
}