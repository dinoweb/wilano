<?php

namespace FDT\MetadataBundle\Tests\Document\Contenuti;

use FDT\MetadataBundle\Document\Contenuti\BaseContenuto;
use FDT\MetadataBundle\Document\Contenuti\Prodotto;
use FDT\MetadataBundle\Document\Attributi\BaseAttributoValue;
use FDT\AdminBundle\Tests\TestCase\TestCase;

class ContenutoTest extends TestCase
{
    public function setUp ()
    {
        parent::setUp();
        
        $this->loadMongoDBDataFixtures ('FDTMetadataBundle', array ('Attributi'));

    }


    public function testNuovoProdotto ()
    {
        $orecchini =  $this->getDm()->getRepository('FDT\MetadataBundle\Document\Tipologie\Prodotti')->getByMyUniqueId('orecchini');
        
        $prodotto = new Prodotto ();
        $prodotto->setNames (array('it_it'=>'Palla it', 'en_us'=>'Palla en'));
        $prodotto->setTipologia ($orecchini);
        
        $attributo = new BaseAttributoValue;
        $attributo->addNames (array('it_it'=>'Palla it', 'en_us'=>'Palla en'));
        $attributo->addSlugs (array('it_it'=>'palla-it', 'en_us'=>'palla-it'));
        $attributo->setConfigId ('configid');
        $attributo->setAttributoId ('setAttributoId');
        $attributo->setUniqueSlug ('setUniqueSlug');
        $attributo->setValue ('setValue');
        
        $prodotto->addAttributoValue ($attributo);
        
        
        $prodotto = $this->getSaver()->save($prodotto);
        

        
    }


}