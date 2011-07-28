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
    
    function __construct(BaseTipologia $tipologia, $service = FALSE)
    {
        $this->setConfigObject ($tipologia, $service);
    }
    
    abstract public function setConfigObject (BaseTipologia $tipologia, $service = FALSE);
    
}
