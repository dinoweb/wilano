<?php

namespace FDT\MetadataBundle\Services\Controller;

class ManageAttributi extends AbstractRestController
{
    
    protected function executeAdd()
    {
    }
    
    protected function executeUpdate()
    {
    }
    
    protected function executeGet()
    {
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
