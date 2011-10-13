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
        
        $arrayAttributi = json_decode ($this->getClient()->getResponse()->getContent(), true);
                               	
       	$this->assertEquals (7, $arrayAttributi['total']);
       	$this->assertEquals (7, count($arrayAttributi['results']));
       	$this->assertEquals ('Peso', $arrayAttributi['results'][0]['uniqueName']);
       	
    }
    
    
}