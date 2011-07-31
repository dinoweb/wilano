<?php
namespace FDT\MetadataBundle\Form\Type\Attributi;

use Symfony\Component\Form\FormBuilder;

/**
* La classe form base per ciascun gli attributi di tipo text
*/
class TextType extends AbstractAttributoType
{
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        $this->buildBaseFields ($builder);
        $builder->add('value', 'text', array('label' => $this->getAttributo ()->getName(), 'required'=>true));
    }

    public function getName()
    {
        return 'TextType';
    }
}
