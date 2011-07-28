<?php
namespace FDT\MetadataBundle\Form\Type\Attributi;

use Symfony\Component\Form\FormBuilder;


/**
* La classe form base per ciascun gli attributi di tipo textarea
*/
class TextareaType extends AbstractAttributoType
{
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder = $this->buildBaseFields ($builder);
        $builder->add('value', 'textarea', array('label' => $this->getAttributo ()->getName()));
    }

    public function getName()
    {
        return 'TextAreaType';
    }
}
