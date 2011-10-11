<?php

namespace FDT\MetadataBundle\Services\Controller;

class ManageAttributi extends AbstractRestController
{
    
    private function getRepository ()
    {
        return $this->documentManager->getRepository('FDT\\MetadataBundle\\Document\\Attributi\\Attributo');
    }
    
    protected function executeAdd()
    {
    }
    
    protected function executeUpdate()
    {
    }
    
    protected function executeGet()
    {
        $arrayResponse = $this->getRepository()->retriveRecords ($this->getLimitData ());
        return $arrayResponse->count ();
        
    }
    
    protected function executeNone ()
    {
        return false;
    }
    
    
    public function indexAction()
    {
        $arrayResponse = $this->executeAction();
                
        
        $jsonResponse = json_encode($arrayResponse);
        $this->response->setContent($jsonResponse);
        $this->response->headers->set('Content-Type', 'application/json');
    
        return ($this->response);
    }
    
}
