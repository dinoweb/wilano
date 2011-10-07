<?php

namespace FDT\MetadataBundle\Tests\Document;

use FDT\MetadataBundle\Document\Tipologie\BaseTipologia;
use FDT\MetadataBundle\Document\Tipologie\Prodotti;
use FDT\AdminBundle\Tests\TestCase\TestCase;



class TipologiaTest extends TestCase
{
	
    /**
     * 
     */
    public function testAddChild ()
    {
        
        $tipologia1 = new Prodotti ();
        $tipologia1->setName ('Gioielli');
        $tipologia1->setUniqueName ('Gioielli');
        
        $tipologia2 = new Prodotti ();
        $tipologia2->setName ('Orecchini');
        $tipologia2->setUniqueName ('Orecchini');
        
        $nodeRoot = $this->getTreeManager ()->getNode ($tipologia1);
                        
        $nodeRoot->addChild ($tipologia2);
        
        $this->getSaver()->save($tipologia2);
        
        
        $descendants = $nodeRoot->getDescendants ();
        
        $this->assertEquals (1, $descendants->count());
        
        $tipologia3 = new Prodotti ();
        $tipologia3->setName ('Bracciali');
        $tipologia3->setUniqueName ('Bracciali');
        
        $nodeRoot->addChild ($tipologia3);
        
        $this->getSaver()->save($tipologia3);
        
        $descendants = $nodeRoot->getDescendants ();
        
        $this->assertEquals (2, $descendants->count());

        
    }
    
    public function testNotAddSameChild ()
    {
        $tipologia1 = new Prodotti ();
        $tipologia1->setName ('Gioielli');
        $tipologia1->setUniqueName ('Gioielli');
        
        $tipologia2 = new Prodotti ();
        $tipologia2->setName ('Orecchini');
        $tipologia2->setUniqueName ('Orecchini');
        
        $nodeRoot = $this->getTreeManager ()->getNode ($tipologia1);
                        
        $nodeRoot->addChild ($tipologia2);
        
        $this->getSaver()->save($tipologia2);
        
        $descendants = $nodeRoot->getDescendants ();
        
        $this->assertEquals (1, $descendants->count());
        
        $nodeRoot->addChild ($tipologia2);
        $nodeRoot->addChild ($tipologia2);
                
        $this->getSaver()->save($tipologia2);
        
        $repository = $this->getDm()->getRepository('FDT\MetadataBundle\Document\Tipologie\Prodotti');
        
        $this->getDm()->clear ();
        
        $tipologiaResult = $repository->getByMyUniqueId ($tipologia1->getId(), 'id');
        
        $nodeTipologiaResult = $this->getTreeManager ()->getNode ($tipologiaResult);
        
        
        
        $descendants = $nodeTipologiaResult->getDescendants (1);
        
        $ancestors = $tipologia2->getAncestors ();
        
        $this->assertEquals (1, $descendants->count());
        $this->assertEquals (1, $ancestors->count());
        
        
    }
    
    public function testMovingNode ()
    {
        $repository = $this->getDm()->getRepository('FDT\MetadataBundle\Document\Tipologie\Prodotti');
        
        $gioielli = new Prodotti ();
        $gioielli->setName ('Gioielli');
        $gioielli->setUniqueName ('Gioielli');
        
        $nodeGioielli = $this->getTreeManager ()->getNode ($gioielli);
        
        $collane = new Prodotti ();
        $collane->setName ('Collane');
        $collane->setUniqueName ('Collane');
        
        $nodeCollane = $this->getTreeManager ()->getNode ($collane);
        
        
        $orecchini = new Prodotti ();
        $orecchini->setName ('Orecchini');
        $orecchini->setUniqueName ('Orecchini');
        
        $nodeOrecchini = $this->getTreeManager ()->getNode ($orecchini);
        
        $orecchiniArgento = new Prodotti ();
        $orecchiniArgento->setName ('Orecchini Argento');
        $orecchiniArgento->setUniqueName ('OrecchiniArgento');
        
        $nodeOrecchiniArgento = $this->getTreeManager ()->getNode ($orecchiniArgento);
        
        //AGGIUNGO COLLANE A GIOIELLI
        $nodeGioielli->addChild($collane);
        
        $this->getSaver()->save($collane);
        
        $this->assertEquals (1, $nodeGioielli->getDescendants()->count());
        $this->assertEquals (1, $collane->getAncestors()->count());
        $this->assertEquals (0, $orecchini->getAncestors()->count());
        
        
        //AGGIUNGO ORECCHINI A GIOIELLI
        $nodeGioielli->addChild($orecchini);
        
        $this->getSaver()->save($orecchini);
        
        $this->assertEquals (2, $nodeGioielli->getDescendants()->count());
        $this->assertEquals (1, $collane->getAncestors()->count());
        $this->assertEquals (1, $orecchini->getAncestors()->count());
        
        //AGGIUNGO ORECCHINI ARGENTO a ORECCHINI
        $nodeOrecchini->addChild($orecchiniArgento);
        
        $this->getSaver()->save($orecchiniArgento);
        
        $this->assertEquals (2, $nodeGioielli->getDescendants()->count());
        $this->assertEquals (3, $nodeGioielli->getDescendants('ALL')->count());
        $this->assertEquals (1, $collane->getAncestors()->count());
        $this->assertEquals (1, $orecchini->getAncestors()->count());
        $this->assertEquals (2, $orecchiniArgento->getAncestors()->count());
        
        //SPOSTO ORECCHINI SOTTO COLLANE
        $nodeCollane->addChild ($orecchini);
        $this->getSaver()->save($orecchini);
        
        $this->assertEquals (1, $nodeGioielli->getDescendants()->count());
        $this->assertEquals (1, $collane->getAncestors()->count());
        $this->assertEquals (2, $orecchini->getAncestors()->count());
        
        //SPOSTO ORECCHINI SOTTO GIOIELLI
        $nodeGioielli->addChild ($orecchini);
        $this->getSaver()->save($orecchini);
        
        $this->assertEquals (2, $nodeGioielli->getDescendants()->count());
        $this->assertEquals (1, $collane->getAncestors()->count());
        $this->assertEquals (1, $orecchini->getAncestors()->count());
        
        //SPOSTO ORECCHINI SOTTO COLLANE
        $nodeCollane->addChild ($orecchini);
        $this->getSaver()->save($orecchini);
        
        $this->assertEquals (1, $nodeGioielli->getDescendants()->count());
        $this->assertEquals (3, $nodeGioielli->getDescendants('ALL')->count());
        $this->assertEquals (1, $collane->getAncestors()->count());
        $this->assertEquals (2, $orecchini->getAncestors()->count());
        $this->assertEquals (3, $orecchiniArgento->getAncestors()->count());
        
        //SPOSTO COLLANE COME ROOT
        $nodeCollane->setAsRoot();
        $this->getSaver()->save($collane);
        
        $this->assertEquals (0, $nodeGioielli->getDescendants()->count());
        $this->assertEquals (1, $nodeCollane->getDescendants()->count());
        $this->assertEquals (0, $collane->getAncestors()->count());
        $this->assertEquals (1, $orecchini->getAncestors()->count());
        $this->assertEquals (2, $orecchiniArgento->getAncestors()->count());
        
        
        
    
    
    
    }
    
    public function testTranslation()
    {
        $tipologia1 = new Prodotti ();
        $tipologia1->setName ('Gioielli');
        $tipologia1->setDescrizione ('Gioielli');
        $tipologia1->setUniqueName ('Gioielli uniqueName');
       	
       	$tipologia1 = $this->getSaver()->save($tipologia1);
       	
       	$tipologia1->setTranslatableLocale('it_it');
       	$tipologia1->setName('Gioielli It');
        
        $tipologia1 = $this->getSaver()->save($tipologia1);
        
        $repository = $this->getDm()->getRepository('FDT\MetadataBundle\Document\Tipologie\TipologiaTranslation');
        $translations = $repository->findTranslations($tipologia1);
                        
        $this->assertEquals ('Gioielli It', $tipologia1->getName());
        $this->assertArrayHasKey('en_us', $translations);
        $this->assertArrayHasKey('it_it', $translations);
        $this->assertEquals('Gioielli', $translations['en_us']['name']);
        $this->assertEquals('Gioielli It', $translations['it_it']['name']);
    }
    
    public function testUpdateTipologia ()
    {
        $tipologia1 = new Prodotti ();
        $tipologia1->setName ('Gioielli');
        $tipologia1->setDescrizione ('Gioielli');
        $tipologia1->setUniqueName ('Gioielli uniqueName');
                
        $tipologia1 = $this->getSaver()->save($tipologia1);
        
        $repository = $this->getDm()->getRepository('FDT\MetadataBundle\Document\Tipologie\Prodotti');
        
        $tipologia2 = $repository->getByMyUniqueId ($tipologia1->getId(), 'id');
        
        $this->assertEquals('Gioielli uniqueName', $tipologia2->getUniqueName());
        
        $tipologia2->setUniqueName ('Palla uniqueName');
        
        $tipologia2 = $this->getSaver()->save($tipologia2);
        
        $tipologia3 = $repository->findOneById ($tipologia2->getId(), 'id');
        
        $this->assertEquals('Palla uniqueName', $tipologia3->getUniqueName());
                
        //$tipologia1->setUniqueName ('Gioielli uniqueName');
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