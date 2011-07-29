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
        $languages = $this->getLanguages();
        $builder->add('value', 'textarea', array('required'=>$this->getConfig ()->getIsObligatory(), 'label' => $this->getAttributo ()->getName()));
    }

    public function getName()
    {
        return 'TextAreaType';
    }
}
