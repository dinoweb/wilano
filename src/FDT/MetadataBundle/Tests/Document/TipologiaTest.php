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
    
    public function testTranslation()
    {
        $tipologia1 = new Prodotti ();
        $tipologia1->setName ('Gioielli');
        $tipologia1->setUniqueName ('Gioielli');
       	
       	$tipologia1 = $this->getSaver()->save($tipologia1);
       	
       	$tipologia1->setTranslatableLocale('it_it');
       	$tipologia1->setName('Gioielli It');
        $tipologia1->setUniqueName ('Gioielli it');
        
        $tipologia1 = $this->getSaver()->save($tipologia1);
        
        $repository = $this->getDm()->getRepository('FDT\MetadataBundle\Document\Tipologie\TipologiaTranslation');
        $translations = $repository->findTranslations($tipologia1);
        
        print_r ($translations);
                
        $this->assertEquals ('Gioielli', $tipologia1->getName());
        $this->assertEquals ('gioielli-it', $tipologia1->getUniqueSlug());
        $this->assertEquals ('gioielli', $tipologia1->getSlug());
        $this->assertArrayHasKey('en_us', $translations);
        $this->assertArrayHasKey('it_it', $translations);
        $this->assertEquals('gioielli', $translations['en_us']['slug']);
        $this->assertEquals('gioielli-it', $translations['it_it']['slug']);
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