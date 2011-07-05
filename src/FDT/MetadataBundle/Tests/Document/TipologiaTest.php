<?php

namespace FDT\MetadataBundle\Tests\Document;

use FDT\MetadataBundle\Document\Tipologia;
use FDT\AdminBundle\Tests\TestCase\TestCase;


class TipologiaTest extends TestCase
{
    public function testNewTipologia()
    {
        $gioielli = new Tipologia ();
        $gioielli->setName ('Gioielli');
                
        $treeManager = $this->getDic()->get('tree_manager'); 
        
        $nodeRoot = $treeManager->getNode ($gioielli);
       	
       	$this->assertEquals ('FDT\doctrineExtensions\NestedSet\NodeWrapper', get_class($nodeRoot));
       	
       	$dm = $this->getDm (); 
    
    }
    
    public function testAddChild ()
    {
    	
    	$tipologia1 = new Tipologia ();
       	$tipologia1->setName ('Mobili');
       	
       	$tipologia2 = new Tipologia ();
       	$tipologia2->setName ('Sedie');
       	
       	$nodeRoot = $this->getTreeManager ()->getNode ($tipologia1);
              	       	
       	$nodeRoot->addChild ($tipologia2);
       	
       	$this->getDocumentManager()->persist($tipologia2);
       	$this->getDocumentManager()->flush ();
       	
       	$descendants = $nodeRoot->getDescendants ();
       	
       	$this->assertEquals (1, $descendants->count());
       	
       	$tipologia3 = new Tipologia ();
       	$tipologia3->setName ('Sgabelli');
       	
       	$nodeRoot->addChild ($tipologia3);
       	
       	$this->getDocumentManager()->persist($categoria3);
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


}