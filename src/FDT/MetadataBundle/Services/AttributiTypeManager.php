<?php
namespace FDT\MetadataBundle\Services;
use FDT\MetadataBundle\Exception\AttributoDoNotExistException;
use Doctrine\ODM\MongoDB\DocumentManager;

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
     * un array con le lingue usate dal sistema
     *
     * @var array
     */
    private $languages;
    
    /**
     *
     * @var Doctrine\ODM\MongoDB\DocumentManager
     */
    private $documentManager;
    
    /**
     * Setta l'array di configurazion degli attributi
     *
     * @param array $attributiTypeConfig 
     * @author Lorenzo Caldara
     */
    function __construct(DocumentManager $documentManager, array $attributiTypeConfig, array $languages)
    {
        $this->attributiTypeConfig = $attributiTypeConfig;
        $this->setLanguages($languages);
        $this->documentManager = $documentManager;
        
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
    
    /** 
     * @param string $attributoTipo il tipo di attributo
     * @return il fully qualified name della classe per la gestione dell'attributo
     * @author Lorenzo Caldara
     */
    public function getFormTypeClass ($attributoTipo)
    {
        $configArrayForAttributo = $this->getConfig ($attributoTipo);
        return $configArrayForAttributo['formType'];
    }
    
    /**
     * @param array $languages
     * @author Lorenzo Caldara
     */
    public function setLanguages (array $languages)
    {
        
        $this->languages = $languages;
        
    }
    
    /**
     * Ritorna un array con le lingue necessarie per la costruzione del modello per l'attributo.
     * se il nome dell'attributo è vuoto, ritorna tutte le stringhe. Se l'attributo è traducibile, ritorna un array di tutte le lingue.
     * Se no ritorna FALSE
     *
     * @param string $attributoType 
     * @return array|false
     * @author Lorenzo Caldara
     */
    public function getLanguages($attributoType = NULL)
    {
        
        return $this->languages;
        
    }
    
    public function getDocumentManager()
    {
        return $this->documentManager;
    }
    
    public function isTranslatable($attributoType)
    {   
        $configArray = $this->getConfig($attributoType);
        
        return $configArray['hasTranslation'];
    }
}
