<?php

namespace FDT\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use FDT\AdminBundle\Services\GetBundlesConfig;

class GetConfigController extends Controller
{
    
    private function getArrayBundlesConfig ()
    {
    	$bundlesConfig = $this->get('bundles_config');
    	$neededConfiguration = $this->getRequest()->get('configFor');
    	
    	$configuration = $bundlesConfig->getArrayBundlesConfig ();
    	
    	$arrayNeededConfig = $configuration[$neededConfiguration];
    	
    	$arrayNeededConfig = $arrayNeededConfig[0];
    	
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
    
    private function getConfigOk ($arrayConfig)
    {
        $arrayConfigOk = array ();
        foreach ($arrayConfig as $fieldConfig)
        {
            $arrayConfigOk[] = $fieldConfig;
        }
        
        return($arrayConfigOk);
        
    }
        
    private function getConfig ()
    {
        $arrayConfig = $this->getArrayBundlesConfig ();
        
        $arrayConfigTraduzioni = $this->manageTranslations($arrayConfig);
        
        $arrayConfigOk = $this->getConfigOk($arrayConfigTraduzioni);
        
        return ($arrayConfigOk);
    }
    
    public function indexAction()
    {
        $response = new Response(json_encode($this->getConfig ()));
		$response->headers->set('Content-Type', 'application/json');
		
		return $response;
    }
}
