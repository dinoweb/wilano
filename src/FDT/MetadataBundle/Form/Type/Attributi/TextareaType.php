<?php
namespace FDT\MetadataBundle\Form\Type\Attributi;

use Symfony\Component\Form\FormBuilder;

/**
* La classe form base per ciascun gli attributi di tipo textarea
*/
class TextareaType extends AbstractAttributoType
{
    protected function buildSpesificFieldType (FormBuilder $builder, $fieldName)
    {
        $builder->add($fieldName, 'textarea', $this->getMyBasicOptions());
    }
    
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder = $this->buildBaseFields ($builder);
        
        $this->buildFieldData ($builder);
        
    }

    public function getName()
    {
        return 'TextAreaType';
    }
}
