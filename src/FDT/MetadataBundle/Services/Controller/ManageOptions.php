<?php

namespace FDT\MetadataBundle\Services\Controller;

class ManageOptions extends AbstractRestController
{
    

    protected function getOwnerClassName ()
    {
        return 'FDT\\MetadataBundle\\Document\\Attributi\\Option';       
    }
    
    
    protected function getRelatedClassName ()
    {
        return 'FDT\\MetadataBundle\\Document\\'.$this->getRelatedClassRequestData ('ownerModel');       
    }
    
    
    protected function executeGet()
    {
        $arrayResponse = $this->getRelatedRepository()->generateRelatedData ($this->getLimitData (), $this->getRelatedClassRequestData())->returnAsArray(false, $this->getOwnerClassName());
        return $arrayResponse;
        
    }
    
    protected function getRelatedDocument ()
    {
    
        return $this->getRelatedRepository()->getByMyUniqueId ($this->getRelatedClassRequestData('ownerId'), 'id');
    
    }
    
    protected function executeAdd()
    {
        $requestData = $this->getData();
        $className = $this->getOwnerClassName();
        $document = new $className;
        $document = $this->setDatiDocument ($document, $requestData);
        
        $relatedDocument = $this->getRelatedDocument ();
        $relatedDocument = $relatedDocument->addOption ($document);
        
        $documentOk = $this->saveDocument($relatedDocument);
        $response = array ('success'=>true, 'message'=>'Record aggiunto con successo');
        return $response;   
    }
    
}
