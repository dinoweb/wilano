<?php

namespace FDT\MetadataBundle\Tests\Document\Attributi;

use FDT\MetadataBundle\Document\Tipologie\Prodotti;
use FDT\AdminBundle\Tests\TestCase\TestCase;
use FDT\MetadataBundle\Exception\ValidatorErrorException;


class TipologiaTest extends TestCase
{
    public function setUp ()
    {
        parent::setUp();
        
        $this->loadMongoDBDataFixtures ('FDTMetadataBundle', array ('Attributi'));

    }
    
    public function testTipologieArray ()
    {
        $orecchini =  $this->getDm()->getRepository('FDT\MetadataBundle\Document\Tipologie\Prodotti')->getByMyUniqueId('orecchini');
        $this->assertEquals(6, count ($orecchini->getAttributiTree ()));
        $this->assertEquals('Lunghezza', $orecchini->getAttributo ('lunghezza')->getUniqueName());
        
        $orecchiniFigli =  $this->getDm()->getRepository('FDT\MetadataBundle\Document\Tipologie\Prodotti')->getByMyUniqueId('orecchini-figli');
        
        $this->assertEquals('orecchini-figli', $orecchiniFigli->getUniqueSlug());
        $this->assertEquals(1, count ($orecchiniFigli->getAttributiTree ($withParent = FALSE)));
        $this->assertEquals(7, count ($orecchiniFigli->getAttributiTree ()));
        

        
        $this->assertEquals('Larghezza', $orecchiniFigli->getAttributo ('larghezza')->getUniqueName());
        $this->assertEquals('Peso', $orecchiniFigli->getAttributo ('peso')->getUniqueName());
        
        $this->assertEquals(1, $orecchiniFigli->getAttributi()->count());
                                    
    }
    
    public function testAttributiOrder ()
    {
    
        $orecchiniFigli =  $this->getDm()->getRepository('FDT\MetadataBundle\Document\Tipologie\Prodotti')->getByMyUniqueId('orecchini-figli');
        
        $arrayKeys = $orecchiniFigli->getAttributiTree ()->getKeys();
                
        $this->assertEquals ('textareatraduzione-unique-name', $arrayKeys[0]);
        $this->assertEquals ('texttranslation-unique-name', $arrayKeys[1]);
        $this->assertEquals ('descrizione', $arrayKeys[2]);
        $this->assertEquals ('larghezza', $arrayKeys[3]);
        $this->assertEquals ('nazione', $arrayKeys[4]);
        $this->assertEquals ('lunghezza', $arrayKeys[5]);
        $this->assertEquals ('peso', $arrayKeys[6]);
            
    }
    
    public function testAttributiOptions ()
    {
    
        $orecchiniFigli =  $this->getDm()->getRepository('FDT\MetadataBundle\Document\Tipologie\Prodotti')->getByMyUniqueId('orecchini-figli');
        
        $optionsNazione = $orecchiniFigli->getAttributo ('nazione')->getOptions();
        
        $this->assertArrayHasKey('italia', $optionsNazione);
        $this->assertArrayHasKey('francia', $optionsNazione);
        $this->assertArrayHasKey('stati-uniti', $optionsNazione);
        $this->assertEquals('IT', $optionsNazione['italia']['value']);
        $this->assertEquals('Italia', $optionsNazione['italia']['name']);
        
            
    }

}