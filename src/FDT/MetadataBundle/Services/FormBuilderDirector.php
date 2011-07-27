<?php
namespace FDT\MetadataBundle\Services;

use FDT\MetadataBundle\Utilities\Contenuti\FormBuilderInterface;
use FDT\MetadataBundle\Document\Tipologie\BaseTipologia;

/**
* Director che gestisce la creazione di un form
*/
class FormBuilderDirector
{
    /**
     * @var FDT\MetadataBundle\Utilities\Contenuti\FormBuilderInterface
     */
    private $formBuilderObject;    
    
    /**
     * @param FormBuilderInterface $formBuilderObject 
     * @author Lorenzo Caldara
     */
    function __construct(FormBuilderInterface $formBuilderObject)
    {
        $this->formBuilderObject = $formBuilderObject;
    }
    
    /**
     * @return FDT\MetadataBundle\Utilities\Contenuti\FormBuilderInterface $formBuilderObject
     * @author Lorenzo Caldara
     */
    private function getFormBuilderObject ()
    {
        return $this->formBuilderObject;
    }
    
    /**
     * Chiama le funzioni del FormBuilder e crea il form - Setta la tipologia di contenuto su cui lavorare
     *
     * @param BaseTipologia $tipologia 
     * @return void
     * @author Lorenzo Caldara
     */
    public function getForm(BaseTipologia $tipologia)
    {
       $this->getFormBuilderObject ()->setTipologia($tipologia);
       $this->buildForms ();
       return $this->getFormBuilderObject ()->getForm();
    }
    
    /**
     * Chiama le funzioni preposte alla creazione dei form e ritorna un unico form
     *
     * @return $form
     * @author Lorenzo Caldara
     */
    public function buildForms()
    {
        $this->getFormBuilderObject ()->buildBaseDataForm ();
        $this->getFormBuilderObject ()->buildBaseAttributiForm ();
        
        
    }
 
}
