<?php

namespace FDT\MetadataBundle\Services\Controller;

class ManageRelations extends AbstractRestController
{
    
    
    protected function getOwnerClassName ()
    {
        return 'FDT\\MetadataBundle\\Document\\'.$this->getRelatedClassRequestData ('ownerModel');       
    }
    
    protected function getRelatedClassName ()
    {
        return 'FDT\\MetadataBundle\\Document\\'.$this->getRelatedClassRequestData ('relatedModel');       
    }
    
    
    protected function getRelationClassName ()
    {
        return 'FDT\\MetadataBundle\\Document\\'.$this->getRelatedClassRequestData ('relationModel');       
    }
    
    
    protected function getOwnerRepository ()
    {
        return $this->documentManager->getRepository($this->getOwnerClassName())->setLanguages($this->languages);
    }
    
    protected function getRelatedRepository ()
    {
        return $this->documentManager->getRepository($this->getRelatedClassName())->setLanguages($this->languages);
    }
    
    protected function getRelationRepository ()
    {
        return $this->documentManager->getRepository($this->getRelationClassName())->setLanguages($this->languages);
    }

    
    protected function executeGet()
    {
        $arrayResponse = $this->getOwnerRepository()->generateRelatedData ($this->getLimitData (), $this->getRelatedClassRequestData())->returnAsArray(true, $this->getRelationClassName());
        return $arrayResponse;
        
    }
    
    protected function getOwnerDocument ()
    {
    
        return $this->getOwnerRepository()->getByMyUniqueId ($this->getRelatedClassRequestData('ownerId'), 'id');
    
    }
    
    protected function getRelationDocument ()
    {
    
        $repository = $this->getRelationRepository();
        $requestData = $this->getData();

        $document = $repository->getByMyUniqueId ($requestData['id'], 'id');
        
        return $document;
        
    }
    
    
    protected function getRelatedDocument ()
    {
    
        $repository = $this->getRelatedRepository();
        $requestData = $this->getData();
        if ($this->getRelatedClassRequestData('relationType') == 'one')
        {
            $document = $repository->getByMyUniqueId ($requestData['id'], 'id');
        }
        
        if ($this->getRelatedClassRequestData('relationType') == 'manyWithConfig')
        {
            $document = $repository->getByMyUniqueId ($requestData['relatedId'], 'id');
        }
        return $document;
        
    }
    
    protected function executeAdd()
    {
        $requestData = $this->getData();
        $ownerDocuument = $this->getOwnerDocument();
        $relatedDocument = $this->getRelatedDocument();
        
        //CREO LA CONFIGURAZIONE
        $relationClassName = $this->getRelationClassName ();        
        $relationDocument = new $relationClassName;
        $relationDocument = $this->setDatiDocument ($relationDocument, $requestData);
        
        //AGGIUNGO IL DOCUMENTO RELAZIONATO ALLA CONFIGURAZIONE
        $setRelationToConfigFunction = $this->getRelatedClassRequestData('setRelationToConfigFunction');
        $relationDocument->$setRelationToConfigFunction ($relatedDocument);
        
        //AGGIUNGO LA CONFIGURAZIONE DELLA RELAZIONE AL DOCUMENTO OWNER
        $setRelationFunction = $this->getRelatedClassRequestData('setRelationFunction');
        $ownerDocuument->$setRelationFunction ($relationDocument);
                
        $documentOk = $this->saveDocument($ownerDocuument);
        $response = array ('success'=>true, 'message'=>'Record aggiunto con successo');
        return $response;   
    }
    
    
    protected function executeUpdate()
    {
        if ($this->getRelatedClassRequestData('relationType') == 'one')
        {
            $document = $this->getOwnerDocument ();
            
            $relatedDocument = $this->getRelatedDocument ();
            
            $setRelationFunction = $this->getRelatedClassRequestData('setRelationFunction');
            
            $document->$setRelationFunction ($relatedDocument);
            
            
            
        }
        
        if ($this->getRelatedClassRequestData('relationType') == 'manyWithConfig')
        {
        
            $requestData = $this->getData();
            $document = $this->getRelationDocument ();
            $document = $this->setDatiDocument ($document, $requestData);
        
        }
        
        
        $documentOk = $this->saveDocument($document);

        $response = array ('success'=>true, 'message'=>'Record aggiornato con successo');
        return $response;
        
        
    }
    
}
