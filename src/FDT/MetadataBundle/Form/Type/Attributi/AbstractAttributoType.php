<?php
namespace FDT\MetadataBundle\Form\Type\Attributi;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use FDT\MetadataBundle\Document\Attributi\Config;


/**
* La base per ciascun form
*/
abstract class AbstractAttributoType extends AbstractType
{
    private $config;
    
    function __construct(Config $config)
    {
        $this->config = $config;
    }
    
    public function getConfig ()
    {
        return $this->config;
    }
    
    protected function getAttributo ()
    {
        return $this->getConfig ()->getAttributo();        
    }
    
    protected function buildBaseFields (FormBuilder $builder)
    {
        $builder->add ('isActive', 'hidden', array (
                                                    'required' => true,
                                                    'data' => array($this->config->getIsActive()),
                                                    
                                                    )
                      
                      );
                      
        $builder->add ('inSearch', 'hidden', array (
                                                    'required' => true,
                                                    'data' => array($this->config->getInSearch()),
                                                    
                                                    )
                      
                      );
        
        $builder->add ('inQuickSearch', 'hidden', array (
                                                    'required' => true,
                                                    'data' => array($this->config->getInQuickSearch()),
                                                    
                                                    )
                      
                      );
        
        $builder->add ('isPubblicable', 'hidden', array (
                                                    'required' => true,
                                                    'data' => array($this->config->getIsPubblicable()),
                                                    
                                                    )
                      
                      );
        
        $builder->add ('isForConfiguration', 'hidden', array (
                                                    'required' => true,
                                                    'data' => array($this->config->getIsForConfiguration()),
                                                    
                                                    )
                      
                      );
        
        $builder->add ('configId', 'hidden', array (
                                                    'required' => true,
                                                    'data' => array($this->config->getId()),
                                                    
                                                    )
                      
                      );
        
        $builder->add ('attributoId', 'hidden', array (
                                                    'required' => true,
                                                    'data' => array($this->getAttributo ()->getId()),
                                                    
                                                    )
                      
                      );
        
        $builder->add ('slug', 'hidden', array (
                                                    'required' => true,
                                                    'data' => array($this->getAttributo ()->getSlug()),
                                                    
                                                    )
                      
                      );
                      
        $builder->add ('name', 'hidden', array (
                                                    'required' => true,
                                                    'data' => array($this->getAttributo ()->getName()),
                                                    
                                                    )
                      
                      );
                      
        $builder->add ('uniqueSlug', 'hidden', array (
                                                    'required' => true,
                                                    'data' => array($this->getAttributo ()->getUniqueSlug()),
                                                    
                                                    )
                      
                      );
        
        return $builder;
    }
        
}
