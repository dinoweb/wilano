<?php

namespace FDT\MetadataBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class updateTipologieController extends Controller
{
    private $tipologia;
    
    private function getLanguageFromString($string)
    {
        preg_match('/-([a-z]{2}_[a-z]{2})-([a-zA-Z]+$)/', $string, $matches);
        return ($matches);
    }
    
    
    private function normalizeData ($requestData)
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
    
    private function getData ()
    {
        $requestData = json_decode($this->get('request')->getContent (), true);
        $requestData = $this->normalizeData ($requestData);
        return $requestData;
    	
    	    	
    }
    
    private function manageTree(array $requestData, $tipologia)
    {
        $documentSaver = $this->get('document_saver');
        $repository = $this->get('doctrine.odm.mongodb.document_manager')->getRepository('FDT\\MetadataBundle\\Document\\Tipologie\\'.$this->getTipologia());
        $treeManager = $this->get('tree_manager');
        
        //$tipologia = $documentSaver->save($tipologia);
        
        if ($requestData['parentId'] != 'idRoot'.$this->getTipologia())
        {
            
            $parentRecord = $repository->getByMyUniqueId ($requestData['parentId'], 'id');
                
            $parentNode = $treeManager->getNode ($parentRecord);
        
            $parentNode->addChild ($tipologia);
            
            $tipologia = $documentSaver->save($tipologia);
            
        }
        else
        {
            $nodeTipologia = $treeManager->getNode ($tipologia);
            $nodeTipologia->setAsRoot ();
            $tipologia = $documentSaver->save($tipologia);
        }
            
            
            return $tipologia;    
    }
    
    private function setDataTipologia ($tipologia)
    {
        $requestData = $this->getData();
        
        $tipologia->setUniqueName ($requestData['uniqueName']);
        $tipologia->setIsActive ($requestData['isActive']);
        $tipologia->setIsPrivate ($requestData['isPrivate']);
        $tipologia->setIsConfigurable ($requestData['isConfigurable']);
        $tipologia->setHasPeriod ($requestData['hasPeriod']);
        
        if (isset($requestData['Translations']))
        {
            foreach ($requestData['Translations'] as $langKey=>$arrayFields)
            {
                $tipologia->setTranslatableLocale($langKey);
                foreach ($arrayFields as $key=>$value)
                {
                    $setFunction = 'set'.ucfirst($key);
                    $tipologia->$setFunction($value);
                }
                
            }
            
        }
        $tipologiaOk = $this->manageTree($requestData, $tipologia);
        return  $tipologiaOk; 
    }
    
    private function executeAdd()
    {
        $requestData = $this->getData();
        $tipologia = $this->getTipologia();
        $className = 'FDT\\MetadataBundle\\Document\\Tipologie\\'.$tipologia;
        $tipologia = new $className;
        
        return $this->setDataTipologia ($tipologia);        
        
    }
    
    private function executeUpdate()
    {
        $repository = $this->get('doctrine.odm.mongodb.document_manager')->getRepository('FDT\\MetadataBundle\\Document\\Tipologie\\'.$this->getTipologia());
        $requestData = $this->getData();
        $tipologia = $repository->getByMyUniqueId ($requestData['id'], 'id');
        $tipologiaOk = $this->setDataTipologia ($tipologia);
        return $tipologiaOk;
    }
    
    private function executeAction ()
    {
        $method = $this->get('request')->getMethod();
        
        switch ($method) {
            case 'POST':
                $tipologia = $this->executeAdd ();
            break;
            
            case 'PUT':
                $tipologia = $this->executeUpdate ();
            break;
            
            default:
                $tipologia = $this->executeNone ();
            break;
        }
        
        return $tipologia;
    }
    
    private function setTipologia($tipologia)
    {
        $this->tipologia = (string) $tipologia;
    }
    
    private function getTipologia()
    {
        return $this->tipologia;
    }
    
    public function indexAction($bundleName, $tipologia)
    {
        $this->setTipologia($tipologia);
        $tipologia = $this->executeAction();
        $jsonResponse = json_encode($tipologia->getUniqueName());
        $response = new Response($jsonResponse);
        $response->headers->set('Content-Type', 'application/json');
    
        return ($response);
    }
}
