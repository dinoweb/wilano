<?php
namespace FDT\MetadataBundle\Form\Type;

use Symfony\Component\Form\FormBuilder;
use FDT\MetadataBundle\Document\Tipologie\BaseTipologia;


/**
* La classe form base per ciascun contenuto con titpologia
*/
class ContenutoType extends AbstractContenutoType
{
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('name');
        $builder->add('tipologiaId', 'hidden', array('required' => true));
        $builder->add('tipologiaPath', 'hidden', array('required' => true));
    }

    public function getName()
    {
        return 'contenuto';
    }
}
