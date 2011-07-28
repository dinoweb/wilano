<?php
namespace FDT\MetadataBundle\Form\Type\Attributi;

use Symfony\Component\Form\FormBuilder;


/**
* La classe form base per ciascun gli attributi di tipo textarea
*/
class SingleSelectType extends AbstractAttributoType
{
    private function getChoises()
    {
        $arrayChoises = array();
        foreach ($this->getAttributo ()->getOptions() as $key => $option) {
            $arrayChoises[$key] = $option['name']; 
        }
        return $arrayChoises;
    }
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder = $this->buildBaseFields ($builder);
        $builder->add('value', 'choice', array('label' => $this->getAttributo ()->getName(),
                                               'choices' => $this->getChoises()
                                               )
                      );
    }

    public function getName()
    {
        return 'SingleSelectType';
    }
}
