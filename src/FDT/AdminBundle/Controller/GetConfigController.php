<?php

namespace FDT\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use FDT\AdminBundle\Services\GetBundlesConfig;

class GetConfigController extends Controller
{
    private $neededConfiguration;
        
    private function getArrayBundlesConfig ()
    {
    	$bundlesConfig = $this->get('bundles_config');
    	$this->neededConfiguration = $this->getRequest()->get('configFor');
    	$filter = $this->getRequest()->get('filter');
    	$configType = $this->getRequest()->get('configType');
    	
    	if ($filter)
    	{
    	    $filter = json_decode ($filter, true);
    	    $this->neededConfiguration = $filter[0]['value'];
    	}
    	
    	$configuration = $bundlesConfig->getArrayBundlesConfig ();
    	    	
    	$arrayNeededConfig = $configuration[$this->neededConfiguration];
    	
    	if ($configType)
    	{
    	    return $arrayNeededConfig[$configType];
    	}
    	    	    	
    	return ($arrayNeededConfig);
    	
    }
    
    private function manageTranslations (array $arrayConfig)
    {
        
        
        if (array_key_exists('Traduzioni', $arrayConfig))
        {
          
        
            $languages = $this->get('contenuti.languages');
            $fieldToBeTranslated = $arrayConfig['Traduzioni'];
            unset ($arrayConfig['Traduzioni']);
        
            foreach ($fieldToBeTranslated as $fieldConfig)
            {
                $fieldConfigOk =  $fieldConfig;
                foreach ($languages->getLanguages() as $languageKey=>$languageName)
                {
                    $nameField = '';
                    $labelField = '';
                    $nameField = 'Translation-'.$languageKey.'-'.$fieldConfig['name'];
                    $labelField = $fieldConfig['text'].' '.$languageKey;
                
                    $fieldConfigOk['name'] = $nameField;
                    $fieldConfigOk['text'] = $labelField;
                    $fieldConfigOk['isTranslated'] = true; 
                
                    $arrayConfig[$nameField] = $fieldConfigOk;
                             
                }
            
            }
        }
        
        return $arrayConfig;
                
    }
    
    private function manageSearchFields (array $arrayConfig)
    {
        
        
        if (array_key_exists('Search', $arrayConfig))
        {
          
        
            $fieldsForSearch = $arrayConfig['Search'];
            unset ($arrayConfig['Search']);
        
            foreach ($fieldsForSearch as $fieldConfig)
            {
                $fieldConfigOk =  $fieldConfig;
                $nameField = 'Search-'.$fieldConfig['operator'].'-'.$fieldConfig['name'];
                $labelField = $fieldConfig['text'];
                
                $fieldConfigOk['name'] = $nameField;
                $fieldConfigOk['text'] = $labelField;
                $fieldConfigOk['useForSearch'] = true; 
                
                $arrayConfig[$nameField] = $fieldConfigOk;
                             
            
            }
        }
        
        return $arrayConfig;
                
    }
    
    private function getConfigOk ($arrayConfig)
    {
        $arrayConfigOk = array ();
        foreach ($arrayConfig as $fieldConfig)
        {
            $fieldConfig['document'] = $this->neededConfiguration;
            $arrayConfigOk[] = $fieldConfig;
        }

        return($arrayConfigOk);
        
    }
        
    private function getConfig ()
    {
        $arrayConfig = $this->getArrayBundlesConfig ();
                
        if ($this->getRequest()->get('configFor'))
        {

            return $arrayConfig;
        }
        
        $arrayConfig = $this->manageTranslations($arrayConfig);
        $arrayConfig = $this->manageSearchFields($arrayConfig);
        
        return $this->getConfigOk ($arrayConfig);
        
    }
    
    public function indexAction()
    {
        
        $response = new Response(json_encode($this->getConfig ()));
		$response->headers->set('Content-Type', 'application/json');
		
		return $response;
    }
}
