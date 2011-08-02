<?php
namespace FDT\MetadataBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use FDT\MetadataBundle\Document\Tipologie\BaseTipologia;


/**
* La base per ciascun form
*/
abstract class AbstractContenutoType extends AbstractType
{
    private $languages;
    
    function __construct(BaseTipologia $tipologia, $service = FALSE, array $languages)
    {
        $this->languages = $languages;
        $this->setConfigObject ($tipologia, $service);
    }
    
    protected function getLanguages()
    {
        return($this->languages);
    }
    
    
    abstract public function setConfigObject (BaseTipologia $tipologia, $service = FALSE);
    
}
