<?php

namespace FDT\MetadataBundle\Tests\Controller;

use FDT\AdminBundle\Tests\TestCase\TestCase;



class ManageOptionsController extends TestCase
{


	public function setUp ()
    {
        parent::setUp();
        
        $this->loadMongoDBDataFixtures ('FDTMetadataBundle', array ('Attributi'));

    }
    
    private function getRestPath ()
    {
        return '/admin/metadata/manageOptions';
    }
    
    private function getDatasetRestPath ()
    {
        return '/admin/metadata/manageDataset';
    }
    
    private function getDataset ()
    {
        $crawler = $this->getClient()->request('GET', $this->getDatasetRestPath());
                
        $arrayAttributi = json_decode ($this->getClient()->getResponse()->getContent(), true);
        
        return $arrayAttributi['results'][0];
                
    }
    
    private function getOptions ($arrayDataset)
    {
        $crawler = $this->getClient()->request(
    		'GET',
			$this->getRestPath(),
			array('ownerModel'=>'Attributi__DataSet', 
			      'ownerId'=>$arrayDataset['id'], 
			      'getRelationFunction'=>'getOptions'
			     )
		);
		
        $arrayOptions = json_decode ($this->getClient()->getResponse()->getContent(), true);
        
        return $arrayOptions;
		
		
    
    }
    
    public function testGetoptions()
    {
    
        $arrayDataset = $this->getDataset();
                
        $crawler = $this->getClient()->request(
    		'GET',
			$this->getRestPath(),
			array('ownerModel'=>'Attributi__DataSet', 
			      'ownerId'=>$arrayDataset['id'], 
			      'getRelationFunction'=>'getOptions'
			     )
		);
        
        $this->assertEquals(200, $this->getClient()->getResponse()->getStatusCode());
        $this->assertTrue($this->getClient()->getResponse()->headers->contains('Content-Type', 'application/json'));
        
        $arrayOptions = json_decode ($this->getClient()->getResponse()->getContent(), true);
        
        $this->assertTrue ($arrayOptions['success']);
        $this->assertEquals (3, $arrayOptions['total']);
               	
    }
    
    
    public function testAddOption ()
    {
        $newOption = array (
    		'name'=>'Romania',
    		'value'=>'Ro',
    		'ordine'=>30,
    		'Translation-it_it-name' => 'Romania',
    		'Translation-en_us-name' => 'Romania inglese',
    		'isNew'=>true,
    	);
    	
    	$jsonNewOption = json_encode ($newOption);
    	
    	$arrayDataset = $this->getDataset();
    	
    	$crawler = $this->getClient()->request(
    		'POST',
			$this->getRestPath(),
			array('ownerModel'=>'Attributi__DataSet', 
			      'ownerId'=>$arrayDataset['id'], 
			      'getRelationFunction'=>'getOptions'
			     ),
			array(),
			array(),
			$content = $jsonNewOption
		);
				
		$arrayResponse = json_decode ($this->getClient()->getResponse()->getContent(), true);
		$this->assertTrue($arrayResponse['success']);
		
		$this->assertEquals(200, $this->getClient()->getResponse()->getStatusCode());
		
		$arrayOptions = $this->getOptions($arrayDataset);
    	$this->assertEquals (4, count($arrayOptions['results']));
    	$this->assertEquals ('Romania', $arrayOptions['results'][3]['name']);
    }
    
    public function testUpdateOptions ()
    {
        $arrayDataset = $this->getDataset();
        $arrayOptions = $this->getOptions($arrayDataset);
        
        $this->assertEquals ('Francia', $arrayOptions['results'][0]['name']);
        
        $newOption = array (
    		'id'=>$arrayOptions['results'][0]['id'],
    		'value'=>'FR',
    		'ordine'=>3,
    		'Translation-it_it-name' => 'Francia It',
    		'Translation-en_us-name' => 'Francia En',
    	);
    	
    	$jsonNewOption = json_encode ($newOption);
    	
    	$crawler = $this->getClient()->request(
    		'PUT',
			$this->getRestPath(),
			array('ownerModel'=>'Attributi__DataSet', 
			      'ownerId'=>$arrayDataset['id'], 
			      'getRelationFunction'=>'getOptions'
			     ),
			array(),
			array(),
			$content = $jsonNewOption
		);
		
    	
    	$arrayResponse = json_decode ($this->getClient()->getResponse()->getContent(), true);
		$this->assertTrue($arrayResponse['success']);
		
		$this->assertEquals(200, $this->getClient()->getResponse()->getStatusCode());
		
		$arrayOptions = $this->getOptions($arrayDataset);
    	$this->assertEquals (3, count($arrayOptions['results']));
    	$this->assertEquals ('Francia It', $arrayOptions['results'][0]['name']);         
    
    
    
    }
    
    

    
    
}