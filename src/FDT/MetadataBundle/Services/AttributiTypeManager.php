<?php
namespace FDT\MetadataBundle\Services;
use FDT\MetadataBundle\Exception\AttributoDoNotExistException;

/**
* Service per la gestione dei tipi di attributi
*/
class AttributiTypeManager 
{
    /**
     * Un array con i diversi tipi di attributi gestiti dal sistema
     *
     * @var array
     */
    private $attributiTypeConfig;
    
    /**
     * Setta l'array di configurazion degli attributi
     *
     * @param array $attributiTypeConfig 
     * @author Lorenzo Caldara
     */
    function __construct(array $attributiTypeConfig)
    {
        $this->attributiTypeConfig = $attributiTypeConfig;
    }
    
    /**
     * @return array $attributiTypeConfig
     * @author Lorenzo Caldara
     */
    public function getAttributiTypeConfig()
    {
        return $this->attributiTypeConfig;
    }
    
    /**
     * @param $key
     * @return array un array con la configurazione per il tipo di attributo richiesto
     * @author Lorenzo Caldara
     */
    public function getConfig ($key)
    {
        $attributiConfig = $this->getAttributiTypeConfig();
        if (isset($attributiConfig[$key])) {
            return $attributiConfig[$key];
        }
        throw new AttributoDoNotExistException(sprintf('L\'attributo %s non e nella lista delle configurazioni', $key));        
    }
    
    public function getFormTypeClass ($attributoTipo)
    {
        $configArrayForAttributo = $this->getConfig ($attributoTipo);
        return $configArrayForAttributo['formType'];
    }
}
