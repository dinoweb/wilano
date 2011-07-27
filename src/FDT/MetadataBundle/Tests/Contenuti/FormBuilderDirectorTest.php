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
        
        $this->assertEquals (2, $formView->count());
        $this->assertEquals (3, $formView->getChild('contenuto')->count());
        
        print_r($form->createView());
    }

}