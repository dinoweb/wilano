<?php

namespace FDT\MetadataBundle\Tests\Controller;

use FDT\AdminBundle\Tests\TestCase\TestCase;



class ManageControlleTipologie extends TestCase
{


	public function setUp ()
    {
        parent::setUp();
        
        $this->loadMongoDBDataFixtures ('FDTMetadataBundle', array ('Attributi'));

    }
    
    public function testGetRoots()
    {

        $crawler = $this->getClient()->request('GET', '/admin/metadata/Prodotti/manageTipologie?node=idRootProdotti');
        
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
    
    public function testAddAndMoveNewTipologia ()
    {
    	
    	$newTipologia = array (
    		'uniqueName'=>'Collane',
    		'isActive'=>true,
    		'isPrivate'=>false,
    		'isConfigurable'=>false,
    		'hasPeriod'=>false,
    		'index'=>10,
    		'parentId'=>'idRootProdotti',
    		'Translation-it_it-name' => 'Collane italiano',
    		'Translation-en_us-name' => 'Collane inglese'
    	);
    	
    	$jsonNewTipologia = json_encode ($newTipologia);
    	
    	$crawler = $this->getClient()->request(
    		'POST',
			'/admin/metadata/Prodotti/manageTipologie',
			array(),
			array(),
			array(),
			$content = $jsonNewTipologia
		);
		
		$arrayResponse = json_decode ($this->getClient()->getResponse()->getContent(), true);
		$this->assertTrue($arrayResponse['success']);
		
		$this->assertEquals(200, $this->getClient()->getResponse()->getStatusCode());
		
		
		
		$crawler = $this->getClient()->request('GET', '/admin/metadata/Prodotti/manageTipologie?node=idRootProdotti');
    	$arrayTipologie = json_decode ($this->getClient()->getResponse()->getContent(), true);
    	$this->assertEquals (2, count($arrayTipologie));
    	
    	//MOVE COLLANE COME FIGLIO DI GIOIELLI
    	$idGioielli = $arrayTipologie[0]['id'];
    	$idCollane = $arrayTipologie[1]['id'];
    	
    	$collane = array (
    		'id'=>$idCollane,
    		'uniqueName'=>'Collane',
    		'isActive'=>true,
    		'isPrivate'=>false,
    		'isConfigurable'=>false,
    		'hasPeriod'=>false,
    		'index'=>10,
    		'parentId'=>$idGioielli,
    		'Translation-it_it-name' => 'Collane italiano',
    		'Translation-en_us-name' => 'Collane inglese'
    	);
    	
    	$jsonCollane = json_encode ($collane);
    	
    	$crawler = $this->getClient()->request(
    		'PUT',
			'/admin/metadata/Prodotti/manageTipologie',
			array(),
			array(),
			array(),
			$content = $jsonCollane
		);
    	
    	
    	$crawler = $this->getClient()->request('GET', '/admin/metadata/Prodotti/manageTipologie?node=idRootProdotti');
    	$arrayTipologie = json_decode ($this->getClient()->getResponse()->getContent(), true);
    	$this->assertEquals (1, count($arrayTipologie));
    	    	
    	$crawler = $this->getClient()->request('GET', '/admin/metadata/Prodotti/manageTipologie?node='.$idGioielli);
    	$arrayChild = json_decode ($this->getClient()->getResponse()->getContent(), true);
    	$this->assertEquals (2, count($arrayChild));
    	
    }
    
    
    
















}