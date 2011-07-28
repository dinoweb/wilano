<?php
namespace FDT\MetadataBundle\Form\Type;

use Symfony\Component\Form\FormBuilder;
use FDT\MetadataBundle\Document\Tipologie\BaseTipologia;
use FDT\doctrineExtensions\NestedSet\TreeManager;
use FDT\MetadataBundle\Exception\NotValidClassException;


/**
* La classe form base per ciascun contenuto con titpologia
*/
class ContenutoType extends AbstractContenutoType
{
    private $tipologia;
    private $treeManager;
    
    public function setConfigObject (BaseTipologia $tipologia, $service = FALSE)
    {
        $this->tipologia = $tipologia;
        if ($service and get_class($service) == 'FDT\doctrineExtensions\NestedSet\TreeManager') {
            $this->treeManager = $service;
        } else {
            throw new NotValidClassException(sprintf('Il servizio %s deve essere invece  FDT\doctrineExtensions\NestedSet\TreeManager', get_class($service)));
        }
        
    }
    
    private function getNode ()
    {
        return $this->treeManager->getNode ($this->tipologia);
    }
    
    private function getPath()
    {
        return $this->getNode()->getPath();
    }
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('name', 'text', array ('required' => true,
                                             'label' => 'Nome'
                                            )
                     );
        
        $builder->add('tipologia', 'hidden', array ('required' => true,
                                                    'data'=>$this->tipologia->getName(),
                                                   )
                     );

        $builder->add('tipologiaId', 'hidden', array('required' => true,
                                                     'data'=>$this->tipologia->getId(),
                                                     )
                      );
                      
        $builder->add('tipologiaPath', 'hidden', array('required' => true,
                                                       'data'=>$this->getPath(),
                                                       )
                      );
    }

    public function getName()
    {
        return 'contenuto';
    }
}
