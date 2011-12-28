<?php
namespace FDT\MetadataBundle\Services;

use Symfony\Component\HttpFoundation\Session;

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
     * La classe con i dati della sessione dell'utente
     *
     * @var Session
     */
    private $session;
    
    /**
     *
     * @param array $languages 
     * @author Lorenzo Caldara
     */
    function __construct(array $languages, Session $session)
    {
        $this->setLanguages($languages);
        $this->setSession($session);
        
    }
    
    public function setSession ($session)
    {
        $this->session = $session;
    }
    
    public function getSession ()
    {
        return $this->session;
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
    
    public function getUserLocale ($lower = true)
    {
        $locale = ($this->getSession()->getLocale());
        if ($lower)
        {
            return strtolower($locale);
        }
        
        return $locale;
    }
    
    private function getLanguageFromString($string)
    {
        preg_match('/-([a-z]{2}_[a-z]{2})-([a-zA-Z]+$)/', $string, $matches);
        return ($matches);
    }
    
    
    public function normalizeTranslationsDataFromForm (array $requestData)
    {
        $arrayKeys = array_keys ($requestData);
        $arrayTranslations = array('Translation'=>array());
        
        $arrayTranslationKeys= array_filter ($arrayKeys, function ($key) use ($requestData){
                                                                    $translationStringNumber =  preg_match('/^Translation-/', $key);
                                                                    
                                                                    if ($translationStringNumber > 0)
                                                                    {
                                                                      return true; 
                                                                    }
   
                                                                    return false;
                                                                    
                                                                }
                                                    
        );
        
        if (count ($arrayTranslationKeys) > 0)
        {
            foreach ($arrayTranslationKeys as $translationKey)
            {
                $arrayTranslationString = $this->getLanguageFromString($translationKey);
                $requestData['Translations'][$arrayTranslationString[1]][$arrayTranslationString[2]] = $requestData[$translationKey];
                unset ($requestData[$translationKey]);
            }
        }
        
        
        
        return ($requestData);
        
    }
    
    public function prepareTranslationDataForForms($document, $repository)
    {
        $translations = $repository->findTranslations($document);
        $arrayTranslation = array ();
        
        if (count ($translations) > 0)
        {   
        //print_r($translations);         
            foreach ($translations as $keyLang=>$arrayValue)
            {
                foreach ($arrayValue as $name=>$value)
                {
                    $stringLangName = 'Translation-'.$keyLang.'-'.$name;
                    $arrayTranslation[$stringLangName] = $value;
                }
            }
        }
    
        return $arrayTranslation;
    
    }
    
}
