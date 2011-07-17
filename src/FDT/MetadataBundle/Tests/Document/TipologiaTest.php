<?php

namespace FDT\MetadataBundle\Tests\Document;

use FDT\MetadataBundle\Document\Tipologie\BaseTipologia;
use FDT\MetadataBundle\Document\Tipologie\Prodotti;
use FDT\AdminBundle\Tests\TestCase\TestCase;


class TipologiaTest extends TestCase
{
    

    public function testAddChild ()
    {
    	
    	$tipologia1 = new Prodotti ();
       	$tipologia1->setName ('Gioielli');
       	
       	$tipologia2 = new Prodotti ();
       	$tipologia2->setName ('Orecchini');
       	
       	$nodeRoot = $this->getTreeManager ()->getNode ($tipologia1);
              	       	
       	$nodeRoot->addChild ($tipologia2);
       	
       	$this->getDocumentManager()->persist($tipologia2);
       	$this->getDocumentManager()->flush ();
       	
       	$descendants = $nodeRoot->getDescendants ();
       	
       	$this->assertEquals (1, $descendants->count());
       	
       	$tipologia3 = new Prodotti ();
       	$tipologia3->setName ('Bracciali');
       	
       	$nodeRoot->addChild ($tipologia3);
       	
       	$this->getDocumentManager()->persist($tipologia3);
       	$this->getDocumentManager()->flush ();
       	
       	$descendants = $nodeRoot->getDescendants ();
       	
       	$this->assertEquals (2, $descendants->count());
    
    
    }
    
    
    private function getTreeManager ()
    {
    
        return $this->getDic()->get('tree_manager'); 
    
    }
    
    
    private function getDocumentManager ()
    {
    
        return $this->getDm(); 
    
    }
    
    public function tearDown ()
    {
    
        $job = $this->getDm()->createQueryBuilder('FDT\MetadataBundle\Document\Tipologie\Prodotti')
               ->findAndRemove()
               ->getQuery()
               ->execute();
    
    
    
    }


}