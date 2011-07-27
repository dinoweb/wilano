<?php
namespace FDT\MetadataBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;


/**
* La base per ciascun form
*/
abstract class AbstractContenutoType extends AbstractType
{
    function __construct($configObject = FALSE)
    {
        if ($configObject) {
            $this->setConfigObject ($configObject);
        }
    }
    
    public function setConfigObject ($configObject)
    {
        
    }
    
}
