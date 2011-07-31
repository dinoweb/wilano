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
                                                                                         'value'=>'palla'
                                                                                         )
                                               ),
                            'contenuto'=>array(
                                                'name'=>array (
                                                                'it_it'=>'palla',
                                                                'en_us'=>'palla en',
                                                              )
                                              )
                            )
                     );
       print_r($form->getErrors()); 
       
       $this->assertTrue($form->isValid());
        
       print_r($form->getNormData());
                
                      
        $this->assertEquals (3, $formView->count());
        $this->assertEquals (4, $formView->getChild('contenuto')->count());
        $this->assertEquals (7, $formView->getChild('attributi')->count());
        
        
    }

}