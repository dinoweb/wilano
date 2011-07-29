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
        
        $attributo5 = new Attributo ();
       	$attributo5->setName ('Nazione');
       	$attributo5->setUniqueName ('Nazione');
       	$attributo5->setTipo ('singleSelect');
       	$attributo5->addDataset($manager->merge($this->getReference('dataset.nazioni')));
       	
        $manager->persist($attributo5);
        
        $attributo6 = new Attributo ();
       	$attributo6->setName ('TextAreaTraduzione');
       	$attributo6->setUniqueName ('TextAreaTraduzione unique name');
       	$attributo6->setTipo ('textareaTranslation');
       	
        $manager->persist($attributo6);
        
        $attributo7 = new Attributo ();
       	$attributo7->setName ('TextTranslation');
       	$attributo7->setUniqueName ('TextTranslation unique name');
       	$attributo7->setTipo ('textTranslation');
       	
        $manager->persist($attributo7);
        
        $manager->flush();
       	
       	$this->addReference('attributo.peso', $attributo);
       	$this->addReference('attributo.descrizione', $attributo2);
       	$this->addReference('attributo.length', $attributo3);
       	$this->addReference('attributo.larghezza', $attributo4);
       	$this->addReference('attributo.nazione', $attributo5);
       	$this->addReference('attributo.textAreaTraduzione', $attributo6);
       	$this->addReference('attributo.textTranslation', $attributo7);
       	
    }
    
    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }

 
}