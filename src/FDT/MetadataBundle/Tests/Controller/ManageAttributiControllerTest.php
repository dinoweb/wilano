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
    
    private function getRestPath ()
    {
        return '/admin/metadata/manageAttributi';
    }
    
    public function testGetAttributi()
    {

        $crawler = $this->getClient()->request('GET', $this->getRestPath());
        
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
			$this->getRestPath(),
			array(),
			array(),
			array(),
			$content = $jsonNewAttributo
		);
		
		$arrayResponse = json_decode ($this->getClient()->getResponse()->getContent(), true);
		$this->assertTrue($arrayResponse['success']);
		
		$this->assertEquals(200, $this->getClient()->getResponse()->getStatusCode());
		
		$crawler = $this->getClient()->request('GET', $this->getRestPath());
    	$arrayAttributi = json_decode ($this->getClient()->getResponse()->getContent(), true);
    	$this->assertEquals (8, count($arrayAttributi['results']));
    }
    
    public function testUpdateAttributi()
    {
        $crawler = $this->getClient()->request('GET', $this->getRestPath());
        
        $this->assertEquals(200, $this->getClient()->getResponse()->getStatusCode());
        
        $arrayAttributi = json_decode ($this->getClient()->getResponse()->getContent(), true);
        
        $this->assertEquals ('Peso', $arrayAttributi['results'][0]['uniqueName']);
       	$this->assertEquals ('Peso visibile', $arrayAttributi['results'][0]['Translation-en_us-name']);
       	
       	$newAttributo = array (
    		'id'=>$arrayAttributi['results'][0]['id'],
    		'uniqueName'=>'Peso updated',
    		'isActive'=>true,
    		'tipo'=>'text',
    		'Translation-it_it-name' => 'Peso italiano',
    		'Translation-en_us-name' => 'Peso inglese'
    	);
    	
    	$jsonNewAttributo = json_encode ($newAttributo);
    	
    	$crawler = $this->getClient()->request(
    		'PUT',
			$this->getRestPath(),
			array(),
			array(),
			array(),
			$content = $jsonNewAttributo
		);
		
		$arrayResponse = json_decode ($this->getClient()->getResponse()->getContent(), true);
		$this->assertTrue($arrayResponse['success']);
		
		$crawler = $this->getClient()->request('GET', $this->getRestPath());
        
        $this->assertEquals(200, $this->getClient()->getResponse()->getStatusCode());
        
        $arrayAttributi = json_decode ($this->getClient()->getResponse()->getContent(), true);
        
        $this->assertEquals ('Peso updated', $arrayAttributi['results'][0]['uniqueName']);
       	$this->assertEquals ('Peso inglese', $arrayAttributi['results'][0]['Translation-en_us-name']);
       	$this->assertEquals ('Peso italiano', $arrayAttributi['results'][0]['Translation-it_it-name']);
		
        
    }
    
    
}