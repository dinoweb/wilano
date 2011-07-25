<?php

namespace FDT\MetadataBundle\Tests\Document\Attributi;

use FDT\MetadataBundle\Document\Attributi\Attributo;
use FDT\MetadataBundle\Document\Attributi\Config;
use FDT\AdminBundle\Tests\TestCase\TestCase;
use FDT\MetadataBundle\Exception\ValidatorErrorException;


class ConfigTest extends TestCase
{
    public function setUp ()
    {
        parent::setUp();
        
        $this->loadMongoDBDataFixtures ('FDTMetadataBundle', array ('Attributi'));

    }
    
    public function testConfigCreation ()
    {
    
        $peso =  $this->getDm()->getRepository('FDT\MetadataBundle\Document\Attributi\Attributo')->getByMyUniqueId('peso');
        $descrizione =  $this->getDm()->getRepository('FDT\MetadataBundle\Document\Attributi\Attributo')->getByMyUniqueId('descrizione');
        $larghezza =  $this->getDm()->getRepository('FDT\MetadataBundle\Document\Attributi\Attributo')->getByMyUniqueId('larghezza');
        $this->assertEquals('larghezza', $larghezza->getUniqueSlug ());
        
        $config = new Config ();
        $config->addAttributo($peso);
        
        $this->getSaver()->save($config);
        
        $this->assertEquals('Peso', $config->getAttributo()->getUniqueName ()); 
        
       	//MODIFICO ATTRIBUTO
       	$config->addAttributo($descrizione);
       	
       	$this->getSaver()->save($config);
       	
       	$this->assertTrue($config->getIsActive());
       	
       	$this->assertEquals('Descrizione', $config->getAttributo()->getUniqueName ());
       	$this->assertEquals('descrizione', $config->getAttributo()->getUniqueSlug ());        
        
        
    
    }

}