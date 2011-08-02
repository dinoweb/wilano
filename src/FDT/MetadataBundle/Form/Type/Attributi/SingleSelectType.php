<?php
namespace FDT\MetadataBundle\Form\Type\Attributi;

use Symfony\Component\Form\FormBuilder;


/**
* La classe form base per ciascun gli attributi di tipo textarea
*/
class SingleSelectType extends AbstractAttributoType
{
    
    protected function buildSpesificFieldType (FormBuilder $builder, $fieldName)
    {
        $options = $this->getMyBasicOptions();
        $options['choices'] = $this->getChoises();

        $builder->add($fieldName, 'choice', $options);

    }
    
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
        $this->buildFieldData ($builder);
    }

    public function getName()
    {
        return 'SingleSelectType';
    }
}
