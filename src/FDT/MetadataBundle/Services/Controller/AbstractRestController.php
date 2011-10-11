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
    
    private function setRequestData ()
    {
        $requestData = json_decode($this->request->getContent (), true);
        if (!is_null($requestData))
        {
            $this->requestData = $this->languages->normalizeTranslationsDataFromForm ($requestData);
        }
        
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
