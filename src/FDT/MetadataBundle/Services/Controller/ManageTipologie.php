<?php

namespace FDT\MetadataBundle\Services\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ManageTipologie
{
    private $tipologia;
    private $documentSaver;
    private $documentManager;
    private $treeManager;
    private $request;
    private $response;
    
    
    public function __construct(\FDT\MetadataBundle\Services\DocumentSaver $documentSaver,
                                \FDT\doctrineExtensions\NestedSet\TreeManager $treeManager, 
                                Request $request,
                                Response $response
                               )
    {
        $this->documentSaver = $documentSaver;
        $this->documentManager = $documentSaver->getDm();
        $this->treeManager = $treeManager;
        $this->request = $request;
        $this->response = $response;
        
    
    
    }
        
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
        $requestData = json_decode($this->request->getContent (), true);
        $requestData = $this->normalizeData ($requestData);
        return $requestData;
    	
    	    	
    }
    
    private function manageTree($tipologia, array $requestData)
    {
        $documentSaver = $this->documentSaver;
        $repository = $this->documentManager->getRepository('FDT\\MetadataBundle\\Document\\Tipologie\\'.$this->getTipologia());
        $treeManager = $this->treeManager;
        
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
    
    private function getTipologie ($node)
    {
        $repository = $this->documentManager->getRepository('FDT\\MetadataBundle\\Document\\Tipologie\\'.$this->getTipologia());
        
        if ($node == 'idRoot'.$this->getTipologia() or $node == 'idRoot')
        {
            
            return $repository->getRoots();
        }
        else
        {
            
            $parentRecord = $repository->getByMyUniqueId ($node, 'id');
            
            $treeManager = $this->treeManager;
        
            $parentNode = $treeManager->getNode ($parentRecord);
            
            return $parentNode->getDescendants(1);
        }
            	
    	    	
    }
    
    private function setDataTipologia ($tipologia, $data)
    {
        
        $tipologia->setUniqueName ($data['uniqueName']);
        $tipologia->setIsActive ($data['isActive']);
        $tipologia->setIsPrivate ($data['isPrivate']);
        $tipologia->setIsConfigurable ($data['isConfigurable']);
        $tipologia->setHasPeriod ($data['hasPeriod']);
        $tipologia->setIndex ($data['index']);
        
        if (isset($data['Translations']))
        {
            foreach ($data['Translations'] as $langKey=>$arrayFields)
            {
                $tipologia->setTranslatableLocale($langKey);
                foreach ($arrayFields as $key=>$value)
                {
                    $setFunction = 'set'.ucfirst($key);
                    $tipologia->$setFunction($value);
                }
                
            }
            
        }
        
        return  $tipologia; 
    }
    
    private function prepareArray($tipologia)
    {
        
        $arrayTipologia = array(
            'id'=>$tipologia->getId(),
            'uniqueName'=>$tipologia->getUniqueName(),
            'uniqueSlug'=>$tipologia->getUniqueSlug(),
            'isActive'=>$tipologia->getIsActive(),
            'isPrivate'=>$tipologia->getIsPrivate(),
            'isConfigurable'=>$tipologia->getIsConfigurable(),
            'hasPeriod'=>$tipologia->getHasPeriod(),            
            'leaf'=>false,
            'parentId'=>null,
            
        );
        
        if ($tipologia->getLevel () > 0)
        {
            $arrayTipologia['parentId'] = $tipologia->getParent ()->getId();
        }
        
        $repository = $this->documentManager->getRepository('FDT\MetadataBundle\Document\Tipologie\TipologiaTranslation');
        $translations = $repository->findTranslations($tipologia);
        
        if (count ($translations) > 0)
        {   
        //print_r($translations);         
            foreach ($translations as $keyLang=>$arrayValue)
            {
                foreach ($arrayValue as $name=>$value)
                {
                    $stringLangName = 'Translation-'.$keyLang.'-'.$name;
                    $arrayTipologia[$stringLangName] = $value;
                }
            }
        }
        
        return $arrayTipologia;
    }
    
    private function executeAdd()
    {
        $requestData = $this->getData();
        $tipologia = $this->getTipologia();
        $className = 'FDT\\MetadataBundle\\Document\\Tipologie\\'.$tipologia;
        $tipologia = new $className;
        $tipologia = $this->setDataTipologia ($tipologia, $requestData);
        $tipologiaOk = $this->manageTree($tipologia, $requestData);
        $response = array ('success'=>true, 'message'=>'Tipologie aggiornate con successo');
        return $response;        
        
    }
    
    private function executeUpdate()
    {
        $repository = $this->documentManager->getRepository('FDT\\MetadataBundle\\Document\\Tipologie\\'.$this->getTipologia());
        $requestData = $this->getData();
        $tipologia = $repository->getByMyUniqueId ($requestData['id'], 'id');
        $tipologia = $this->setDataTipologia ($tipologia, $requestData);
        $tipologiaOk = $this->manageTree($tipologia, $requestData);
        $response = array ('success'=>true, 'message'=>'Tipologie aggiornate con successo');
        return $response;
    }
    
    private function executeGet()
    {
        $arrayResponse = array();
        
        $node = $this->request->query->get('node', 'idRoot');
        $tipologie = $this->getTipologie($node);
        
        if ($tipologie->count() > 0)
        {
            foreach ($tipologie as $key => $value) {
                $arrayResponse[] = $this->prepareArray ($value);
            }
            
        }
        
        return $arrayResponse;
    }
    
    private function executeNone ()
    {
        return false;
    }
    
    private function executeAction ()
    {
        $method = $this->request->getMethod();
        
        switch ($method) {
            case 'POST':
                $result = $this->executeAdd ();
            break;
            
            case 'PUT':
                $result = $this->executeUpdate ();
            break;
            
            case 'GET':
                $result = $this->executeGet ();
            break;
            
            default:
                $result = $this->executeNone ();
            break;
        }
        
        return $result;
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
        $arrayResponse = $this->executeAction();
                
        
        $jsonResponse = json_encode($arrayResponse);
        $this->response->setContent($jsonResponse);
        $this->response->headers->set('Content-Type', 'application/json');
    
        return ($this->response);
    }
}
