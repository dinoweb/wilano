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
       	$this->assertEquals ('Peso visibile', $arrayAttributi['results'][0]['Translation-en_us-name']);
       	
    }
    
    public function testAddAttributi ()
    {
        $newAttributo = array (
    		'uniqueName'=>'Peso',
    		'isActive'=>true,
    		'tipo'=>'text',
    		'Translation-it_it-name' => 'Peso italiano',
    		'Translation-en_us-name' => 'Peso inglese'
    	);
    	
    	$jsonNewAttributo = json_encode ($newAttributo);
    	
    	$crawler = $this->getClient()->request(
    		'POST',
			'/admin/metadata/manageAttributi',
			array(),
			array(),
			array(),
			$content = $jsonNewAttributo
		);
		
		$arrayResponse = json_decode ($this->getClient()->getResponse()->getContent(), true);
		$this->assertTrue($arrayResponse['success']);
		
		$this->assertEquals(200, $this->getClient()->getResponse()->getStatusCode());
		
		$crawler = $this->getClient()->request('GET', '/admin/metadata/manageAttributi');
    	$arrayAttributi = json_decode ($this->getClient()->getResponse()->getContent(), true);
    	$this->assertEquals (8, count($arrayAttributi['results']));
    }
    
    
}