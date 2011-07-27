<?php

namespace FDT\MetadataBundle\Utilities\Contenuti;

use FDT\MetadataBundle\Utilities\Contenuti\FormBuilderInterface;
use FDT\MetadataBundle\Document\Tipologie as DocumentTipologia;

/**
* SI OCCUPA DI COSTRUIRE IL FORM SULLA BASE DI UNA TIPOLOGIA
*/
class FormBuilderContenuti extends FormBuilderInterface
{
    /**
     * Tipologia sulla base della quale costruire il form
     *
     * @var FDT\MetadataBundle\Document\Tipologie\BaseTipologia
     */
    private $tipologia;
    
    /**
     * Setta la tipologia su cui lavorare
     *
     * @param BaseTipologia $tipologia 
     * @return void
     * @author Lorenzo Caldara
     */
    public function setTipologia(DocumentTipologia\BaseTipologia $tipologia)
    {
        $this->tipologia = $tipologia;
    }
    
    /**
     * @return FDT\MetadataBundle\Document\Tipologie\BaseTipologia
     * @author Lorenzo Caldara
     */
    public function getTipologia()
    {
        return ($this->tipologia);
    }
    
    public function buildBaseDataForm()
    {
        $this->getFormBuilder()->add('contenuto', $this->getFormTypeInstance ('contenuto'));
    }
    
}
