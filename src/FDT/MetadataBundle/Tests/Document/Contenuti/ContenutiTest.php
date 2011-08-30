<?php

namespace FDT\MetadataBundle\Tests\Document\Contenuti;

use FDT\MetadataBundle\Document\Contenuti\BaseContenuto;
use FDT\MetadataBundle\Document\Contenuti\Prodotti;
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
        
        $prodotto = new Prodotti ();
        $prodotto->setNames (array('it_it'=>'Palla it', 'en_us'=>'Palla en'));
        $prodotto->setTipologia ($orecchini);
        
        $attributo = new BaseAttributoValue;
        $attributo->addNames (array('it_it'=>'Palla it', 'en_us'=>'Palla en'));
        $attributo->addSlugs (array('it_it'=>'palla-it', 'en_us'=>'palla-it'));
        $attributo->setConfigId ('configid');
        $attributo->setAttributoId ('setAttributoId');
        $attributo->setAttributoTipo ('setAttributoTipo');
        $attributo->setUniqueSlug ('setUniqueSlug');
        $attributo->setValue ('setValue');
        $attributo = $this->getSaver()->save($attributo, FALSE);
        
        $prodotto->addAttributoValue ($attributo);
        
        $prodotto = $this->getSaver()->save($prodotto);
        
        
        $prodottoResult =  $this->getDm()->getRepository('FDT\MetadataBundle\Document\Contenuti\Prodotti')->findOneById(1);
        
        $this->assertArrayHasKey('en_us', $prodottoResult->getNames());
        $this->assertEquals('Palla it', $prodottoResult->getNameLocale('it_it'));
        $this->assertEquals('Palla it', $prodottoResult->getNameLocale('culo'));
        $this->assertEquals('Palla en', $prodottoResult->getNameLocale('en_us'));
        
        $this->assertEquals(1, $prodottoResult->getAttributi()->count());
        
    }
    
    public function testNuovoProdottoDaForm()
    {
        $formBuilderDirector = $this->getDic ()->get('contenuti.form_builder_director');
        $orecchiniFigli =  $this->getDm()->getRepository('FDT\MetadataBundle\Document\Tipologie\Prodotti')->getByMyUniqueId('orecchini-figli');
        $form = $formBuilderDirector->getForm ($orecchiniFigli);
        $formView = $form->createView();
        
        $tokenVars = $formView->get('form')->getChild('_token')->getVars();
        $tokenValue = $tokenVars['value'];
        
        $form->bind (array('_token'=>$tokenValue, 
                            'attributi'=>array(
                                                'textareatraduzione-unique-name'=>array (
                                                                                         'value'=> array ('it_it'=>'Palla', 'en_us'=>'Ball')
                                                                                         ),
                                                'descrizione'=>array (
                                                                        'value'=>'prova descrizione testo'
                                                                      ),
                                                'texttranslation-unique-name'=>array (
                                                                                         'value'=> array ('it_it'=>'Text it', 'en_us'=>'Text en')
                                                                                         ),
                                                'larghezza'=>array (
                                                                        'value'=>10
                                                                      ),
                                                'lunghezza'=>array (
                                                                        'value'=>20
                                                                      ),
                                                'peso'=>array (
                                                                        'value'=>30
                                                                      ),
                                                'nazione'=>array (
                                                                        'value'=>'it_it'
                                                                      ),
                                               ),
                            'contenuto'=>array(
                                                'name'=>array (
                                                                'it_it'=>'Palla',
                                                                'en_us'=>'Palla en',
                                                              )
                                              )
                            )
                     );
       //print_r($form->getErrors()); 
       
       $this->assertTrue($form->isValid());
       
       $formData = $form->getNormData();
       
       $contenutoBuilder = $this->getDic ()->get('contenuti.contenuto_builder');
       
       $contenuto = $contenutoBuilder->build ($formData);
       
       $prodottoResult =  $this->getDm()->getRepository('FDT\MetadataBundle\Document\Contenuti\Prodotti')->findOneById(1);
       
       $this->assertArrayHasKey('en_us', $prodottoResult->getNames());
       $this->assertEquals('Palla', $prodottoResult->getNameLocale('it_it'));
       $this->assertEquals('Palla en', $prodottoResult->getNameLocale('en_us'));
       
       $attributi = $prodottoResult->getAttributi();
       
       $this->assertEquals(7, $attributi->count());
       
       $this->assertArrayHasKey('en_us', $attributi[0]->getValue());
       $this->assertArrayHasKey('it_it', $attributi[0]->getValue());
       $this->assertEquals('Palla', $attributi[0]->getValueLocale('it_it'));
       $this->assertEquals('Ball', $attributi[0]->getValueLocale('en_us'));
       
       $attributoPeso = $prodottoResult->getAttributo('peso');
       $this->assertInternalType('float', $attributoPeso->getValue());
       $this->assertEquals(30, $attributoPeso->getValue());
       
       $attributoDescrizione = $prodottoResult->getAttributo('descrizione');
       $this->assertInternalType('string', $attributoDescrizione->getValue());
       $this->assertEquals('prova descrizione testo', $attributoDescrizione->getValue());
       
       $attributoTextareaTraduzione = $prodottoResult->getAttributo('textareatraduzione-unique-name');
       $this->assertInternalType('array', $attributoTextareaTraduzione->getValue());
       $this->assertArrayHasKey('en_us', $attributoTextareaTraduzione->getValue());
       $this->assertArrayHasKey('it_it', $attributoTextareaTraduzione->getValue());
       $this->assertEquals('Palla', $attributoTextareaTraduzione->getValueLocale('it_it'));
       $this->assertEquals('Ball', $attributoTextareaTraduzione->getValueLocale('en_us'));
       
              
    }


}