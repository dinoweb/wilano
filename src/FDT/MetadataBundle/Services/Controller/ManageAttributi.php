<?php

namespace FDT\MetadataBundle\Services\Controller;

class ManageAttributi extends AbstractRestController
{
    
    protected function getFullClassName ()
    {
        
        return 'FDT\\MetadataBundle\\Document\\Attributi\\Attributo';
        
    }
    
    
    
    public function getTranslationRepository ()
    {
        return $this->documentManager->getRepository('FDT\\MetadataBundle\\Document\\Attributi\\AttributoTranslation');
    }
    
    
    private function setDatiAttributo ($attributo, $data)
    {
        
        $attributo->setUniqueName ($data['uniqueName']);
        $attributo->setIsActive ($data['isActive']);
        $attributo->setTipo ($data['tipo']);
        
        $attributo = $this->manageTranslationsData ($attributo, $data);
        
        return  $attributo; 
    }
    
    protected function executeAdd()
    {
        $requestData = $this->getData();
        $className = $this->getFullClassName();
        $attributo = new $className;
        $attributo = $this->setDatiAttributo ($attributo, $requestData);
        $attributoOk = $this->saveAttributo($attributo);
        $response = array ('success'=>true, 'message'=>'Attributo aggiunto con successo');
        return $response;   
    }
    
    protected function executeUpdate()
    {
    }
    
    protected function executeGet()
    {
        $arrayResponse = $this->getRepository()->generateCursor ($this->getLimitData ())->returnAsArray();
        return $arrayResponse;
        
    }
    
    protected function executeNone ()
    {
        return false;
    }
    
    private function saveAttributo($attributo)
    {
                
        $attributo = $this->documentSaver->save($attributo);            
            
        return $attributo;    
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
