<?php
namespace FDT\MetadataBundle\Form\Type\Attributi;

use Symfony\Component\Form\FormBuilder;


/**
* La classe form base per ciascun gli attributi di tipo textarea
*/
class NumberType extends AbstractAttributoType
{
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder = $this->buildBaseFields ($builder);
        $builder->add('value', 'number', array('label' => $this->getAttributo ()->getName()));
    }

    public function getName()
    {
        return 'NumberType';
    }
}
