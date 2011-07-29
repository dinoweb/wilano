<?php
namespace FDT\MetadataBundle\Form\Type\Attributi;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use FDT\MetadataBundle\Document\Attributi\Config;
use FDT\MetadataBundle\Services\AttributiTypeManager;


/**
* La base per ciascun form
*/
abstract class AbstractAttributoType extends AbstractType
{
    /**
     * @var FDT\MetadataBundle\Document\Attributi\Config
     */
    private $config;
    
    /**
     * @var FDT\MetadataBundle\Services\AttributiTypeManager
     */
    private $attributiTypeManager;
    
    /**
     * @param Config $config 
     * @param AttributiTypeManager $attributiTypeManager 
     * @author Lorenzo Caldara
     */
    function __construct(Config $config, AttributiTypeManager $attributiTypeManager)
    {
        $this->config = $config;
        $this->attributiTypeManager = $attributiTypeManager;
    }
    
    /**
     * @return FDT\MetadataBundle\Services\AttributiTypeManager
     * @author Lorenzo Caldara
     */
    protected function getAttributiTypeManager()
    {
        return ($this->attributiTypeManager);
    }
    
    protected function getLanguages()
    {
        return $this->getAttributiTypeManager()->getLanguages();
    }
    
    /**
     * @return FDT\MetadataBundle\Document\Attributi\Config
     *
     * @author Lorenzo Caldara
     */
    public function getConfig ()
    {
        return ($this->config);
    }
    
    /**
     * @return FDT\MetadataBundle\Document\Attributi\Attributo
     *
     * @author Lorenzo Caldara
     */
    protected function getAttributo ()
    {
        return $this->getConfig ()->getAttributo();        
    }
    
    private function getFormForName(FormBuilder $builder)
    {
       $arrayName = array();
       foreach ($this->getLanguages() as $key => $value) {
            $arrayName[$key] = $this->getAttributo ()->getSlug();
       }
       
       return $builder->add('name', 'hidden', array ('data' => $arrayName, 'read_only' => true));

    }
    
    /**
     * Crea i campi di default per ogni attributo - Si tratta dei campi contenenti i parametri di configurazione dell'attributo
     *
     * @param FormBuilder $builder 
     * @return FormBuilder
     * @author Lorenzo Caldara
     */
    protected function buildBaseFields(FormBuilder $builder)
    {
        $builder->add ('isActive', 'hidden', array (
                                                    'data' => $this->config->getIsActive(),
                                                    'read_only' => true
                                                    
                                                    )
                      
                      );
                      
        $builder->add ('inSearch', 'hidden', array (
                                                    'data' => $this->config->getInSearch(),
                                                    'read_only' => true
                                                    
                                                    )
                      
                      );
        
        $builder->add ('inQuickSearch', 'hidden', array (
                                                    'data' => $this->config->getInQuickSearch(),
                                                    'read_only' => true
                                                    
                                                    )
                      
                      );
        
        $builder->add ('isPubblicable', 'hidden', array (
                                                    'data' => $this->config->getIsPubblicable(),
                                                    'read_only' => true
                                                    
                                                    )
                      
                      );
        
        $builder->add ('isForConfiguration', 'hidden', array (
                                                    'data' => $this->config->getIsForConfiguration(),
                                                    'read_only' => true
                                                    
                                                    )
                      
                      );
        
        $builder->add ('configId', 'hidden', array (
                                                    'data' => $this->config->getId(),
                                                    'read_only' => true
                                                    
                                                    )
                      
                      );
        
        $builder->add ('attributoId', 'hidden', array (
                                                    'data' => $this->getAttributo ()->getId(),
                                                    'read_only' => true
                                                    
                                                    )
                      
                      );
        
        $builder->add ('slug', 'hidden', array (
                                                    'data' => $this->getAttributo ()->getSlug(),
                                                    'read_only' => true
                                                    
                                                    )
                      
                      );
                      
        $builder->add ('name', 'hidden', array (
                                                    'data' => $this->getAttributo ()->getName(),
                                                    'read_only' => true
                                                    
                                                    )
                      
                      );
                      
        $builder->add ('uniqueSlug', 'hidden', array (
                                                    'data' => $this->getAttributo ()->getUniqueSlug(),
                                                    'read_only' => true
                                                    
                                                    )
                      
                      );
        
        $builder = $this->getFormForName($builder);
        
        return $builder;
    }
        
}
