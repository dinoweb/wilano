<?php
namespace FDT\MetadataBundle\Form\Type\Attributi;

use Symfony\Component\Form\FormBuilder;

/**
* La classe form base per ciascun gli attributi di tipo text
*/
class TextType extends AbstractAttributoType
{
    
    protected function buildSpesificFieldType (FormBuilder $builder, $fieldName)
    {
        $builder->add($fieldName, 'text', $this->getMyBasicOptions());
    }
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        $this->buildBaseFields ($builder);
        $this->buildFieldData ($builder);
    }

    public function getName()
    {
        return 'TextType';
    }
}
