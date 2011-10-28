<?php

namespace FDT\MetadataBundle\Tests\Controller;

use FDT\AdminBundle\Tests\TestCase\TestCase;



class ManageDatasetController extends TestCase
{


	public function setUp ()
    {
        parent::setUp();
        
        $this->loadMongoDBDataFixtures ('FDTMetadataBundle', array ('Attributi'));

    }
    
    private function getRestPath ()
    {
        return '/admin/metadata/manageDataset';
    }
    
    public function testGetDataset()
    {

        $crawler = $this->getClient()->request('GET', $this->getRestPath());
        
        $this->assertEquals(200, $this->getClient()->getResponse()->getStatusCode());
        $this->assertTrue($this->getClient()->getResponse()->headers->contains('Content-Type', 'application/json'));
        
        $arrayAttributi = json_decode ($this->getClient()->getResponse()->getContent(), true);
                                       	
       	$this->assertEquals (1, $arrayAttributi['total']);
       	$this->assertEquals (1, count($arrayAttributi['results']));
       	$this->assertEquals ('Nazioni', $arrayAttributi['results'][0]['uniqueName']);
       	$this->assertEquals ('Nazioni', $arrayAttributi['results'][0]['Translation-en_us-name']);
       	
    }
    
    public function testAddDataset ()
    {
        $newAttributo = array (
    		'uniqueName'=>'Regione',
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
    	$this->assertEquals (2, count($arrayAttributi['results']));
    }
    
    public function testUpdateDataset()
    {
        $crawler = $this->getClient()->request('GET', $this->getRestPath());
        
        $this->assertEquals(200, $this->getClient()->getResponse()->getStatusCode());
        
        $arrayAttributi = json_decode ($this->getClient()->getResponse()->getContent(), true);
        
        $this->assertEquals ('Nazioni', $arrayAttributi['results'][0]['uniqueName']);
       	$this->assertEquals ('Nazioni', $arrayAttributi['results'][0]['Translation-en_us-name']);
       	
       	$newAttributo = array (
    		'id'=>$arrayAttributi['results'][0]['id'],
    		'uniqueName'=>'Nazioni updated',
    		'tipo'=>'text',
    		'Translation-it_it-name' => 'Nazioni italiano',
    		'Translation-en_us-name' => 'Nazioni inglese'
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
        
        $this->assertEquals ('Nazioni updated', $arrayAttributi['results'][0]['uniqueName']);
       	$this->assertEquals ('Nazioni inglese', $arrayAttributi['results'][0]['Translation-en_us-name']);
       	$this->assertEquals ('Nazioni italiano', $arrayAttributi['results'][0]['Translation-it_it-name']);
		
        
    }
    
    
}