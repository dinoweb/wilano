<?php

namespace FDT\MetadataBundle\Tests\Controller;

use FDT\AdminBundle\Tests\TestCase\TestCase;



class ManageAttributiController extends TestCase
{


	public function setUp ()
    {
        parent::setUp();
        
        $this->loadMongoDBDataFixtures ('FDTMetadataBundle', array ('Attributi'));

    }
    
    public function testGetAttributi()
    {

        $crawler = $this->getClient()->request('GET', '/admin/metadata/manageAttributi');
        
        $this->assertEquals(200, $this->getClient()->getResponse()->getStatusCode());
        $this->assertTrue($this->getClient()->getResponse()->headers->contains('Content-Type', 'application/json'));
        
        $arrayTipologie = json_decode ($this->getClient()->getResponse()->getContent(), true);
                        
       	$this->assertEquals(200, $this->getClient()->getResponse()->getStatusCode());
       	
       	$this->assertEquals (1, count($arrayTipologie));
       	$this->assertEquals ('Gioielli', $arrayTipologie[0]['uniqueName']);
       	
       	//GET CHILDREN 
       	$crawler = $this->getClient()->request('GET', '/admin/metadata/Prodotti/manageTipologie?node='.$arrayTipologie[0]['id']);
       	
       	$arrayTipologieChildren = json_decode ($this->getClient()->getResponse()->getContent(), true);
       	       	
       	$this->assertEquals (1, count($arrayTipologieChildren));
       	$this->assertEquals ('Orecchini', $arrayTipologieChildren[0]['uniqueName']);
    }
    
    
}