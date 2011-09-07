<?php
namespace FDT\MetadataBundle\Services;

/**
* Service per la gestione dei tipi di attributi
*/
class Languages 
{    
    /**
     * un array con le lingue usate dal sistema
     *
     * @var array
     */
    private $languages;
    
    /**
     *
     * @param array $languages 
     * @author Lorenzo Caldara
     */
    function __construct(array $languages)
    {
        $this->setLanguages($languages);
        
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
     *
     * @param string $attributoType 
     * @return array|false
     * @author Lorenzo Caldara
     */
    public function getLanguages()
    {
        
        return $this->languages;
        
    }
    
    public function getLanguagesJson()
    {
       $arrayOk = array();
        foreach ($this->getLanguages() as $key => $value) {
            $arrayOk[] = array ('name'=>$value, 'value'=>$key);
        }
        return json_encode($arrayOk);
    }
    
}
