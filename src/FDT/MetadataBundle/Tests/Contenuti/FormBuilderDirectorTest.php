<?php

namespace FDT\MetadataBundle\Tests\Contenuti;

use FDT\AdminBundle\Tests\TestCase\TestCase;

class FormBuildeDirectorTest extends TestCase
{
    
    public function setUp ()
    {
        parent::setUp();
        
        $this->loadMongoDBDataFixtures ('FDTMetadataBundle', array ('Attributi'));

    }
    
    public function testCreateDirector ()
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
                                                                'it_it'=>'palla',
                                                                'en_us'=>'palla en',
                                                              )
                                              )
                            )
                     );
       //print_r($form->getErrors()); 
       
       $this->assertTrue($form->isValid());
       $formData = $form->getNormData();
       
       
       //print_r($formView);
        
       //print_r($form->getNormData());
                             
        $this->assertEquals (3, $formView->count());
        $this->assertEquals (5, $formView->getChild('contenuto')->count());
        $this->assertEquals (7, $formView->getChild('attributi')->count());
        
        
    }

}