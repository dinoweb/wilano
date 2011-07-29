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
    
    private function getFormForName(FormBuilder $builder)
    {
       $builder->add('name');
       foreach ($this->getLanguages() as $key => $value) {
            $builder->get('name')->add($key)->get($key)->add ('value', 'text', array ('required' => true, 'label' => 'Nome '.$key));
       }
       
       return $builder;

    }
    
    /**
     * @param FormBuilder $builder 
     * @param array $options 
     * @return FormBuilder
     * @author Lorenzo Caldara
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        
        
        $builder->add('tipologia', 'hidden', array (
                                                    'data'=>$this->tipologia->getName(),
                                                    'read_only' => true
                                                   )
                     );

        $builder->add('tipologiaId', 'hidden', array(
                                                     'data'=>$this->tipologia->getId(),
                                                     'read_only' => true
                                                     )
                      );
                      
        $builder->add('tipologiaPath', 'hidden', array(
                                                       'data'=>$this->getPath(),
                                                       'read_only' => true
                                                       )
                      );
        
        $this->getFormForName($builder);
    }

    public function getName()
    {
        return 'contenuto';
    }
}
