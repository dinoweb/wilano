<?php

namespace FDT\MetadataBundle\Services\Controller;


abstract class AbstractRestController
{
    protected $documentSaver;
    protected $documentManager;
    protected $request;
    protected $response;
    protected $languages;
    protected $requestData;
    
    
    public function __construct(\FDT\MetadataBundle\Services\DocumentSaver $documentSaver,
                                \Symfony\Component\HttpFoundation\Request $request,
                                \Symfony\Component\HttpFoundation\Response $response,
                                \FDT\MetadataBundle\Services\Languages $languagesManager
                               )
    {
        $this->documentSaver = $documentSaver;
        $this->documentManager = $documentSaver->getDm();
        $this->request = $request;
        $this->response = $response;
        $this->languages = $languagesManager;
        
        $this->setRequestData ();
    
    }
    
    protected function getRepository ()
    {
        return $this->documentManager->getRepository($this->getFullClassName())->setLanguages($this->languages);
    }
    
    protected function getLimitData ()
    {
        $arrayLimit = array();
        $arrayLimit['limit'] = $this->request->query->get('limit', 20);
        $arrayLimit['skip'] = $this->request->query->get('start', 0);
        
        return $arrayLimit;
    }
    
    protected function setRequestData ()
    {
        $requestData = json_decode($this->request->getContent (), true);
        if (!is_null($requestData))
        {
            $this->requestData = $this->languages->normalizeTranslationsDataFromForm ($requestData);
        }
        
    }
    
    protected function manageTranslationsData ($document, $data)
    {
        if (!isset($data['Translations']))
        {
            return $document;
        }
        
        $repository = $this->getTranslationRepository();
        $useLocale = $this->languages->getUserLocale ();
        
        foreach ($data['Translations'] as $langKey=>$arrayFields)
        {   
            
            foreach ($arrayFields as $key=>$value)
            {
                if ($useLocale == $langKey)
                {
                    $setFunction = 'set'.ucfirst($key);
                    $document->$setFunction($value);
                
                }
                else
                {
                    $repository->translate($document, $key, $langKey, $value);
                }
                
                
                
                
            }
            
        }
        return $document;
        
        
        
    }
    
    protected function getData ()
    {
        return $this->requestData;    	    	
    }
    
    protected function getArrayResponseGet (array $arrayData)
    {
        $arrayResponse['success'] = true;
        $arrayResponse['total'] = count ($arrayData);
        $arrayResponse['results'] = $arrayData;
        
        return $arrayResponse;
    }
    
    abstract protected function executeAdd();
    
    abstract protected function executeUpdate();
    
    abstract protected function executeGet();
    
    protected function executeNone ()
    {
        return false;
    }
    
    protected function executeAction ()
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
    
    
}
