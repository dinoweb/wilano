<?php
namespace FDT\MetadataBundle\Form\Type;

use Symfony\Component\Form\FormBuilder;


/**
* La classe form base per ciascun contenuto con titpologia
*/
class AttributiType extends AbstractContenutoType
{
    private $attributiConfig; 
    
    public function setConfigObject ($attributiConfig)
    {
        $this->attributiConfig = $attributiConfig;
        
    }
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        foreach ($this->attributiConfig as $key => $value) {
            $builder->add($value->getAttributo()->getSlug());
        }
        
    }

    public function getName()
    {
        return 'attributi';
    }
}
