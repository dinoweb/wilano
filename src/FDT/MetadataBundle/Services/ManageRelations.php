<?php

namespace FDT\MetadataBundle\Services\Controller;

class ManageRelations extends AbstractRestController
{
    

    protected function getFullClassName ()
    {
        return 'FDT\\MetadataBundle\\Document\\'.$this->getRelatedClassRequestData ('relatedType');       
    }
    
    
    protected function getFullRelatedClassName ()
    {
        return 'FDT\\MetadataBundle\\Document\\'.$this->getRelatedClassRequestData ('ownerType');       
    }
    
    
    protected function executeGet()
    {
        $arrayResponse = $this->getRelatedRepository()->generateRelatedData ($this->getLimitData (), $this->getRelatedClassRequestData())->returnAsArray(false, $this->getFullClassName());
        return $arrayResponse;
        
    }
    
    protected function getRelatedDocument ()
    {
    
        return $this->getRelatedRepository()->getByMyUniqueId ($this->getRelatedClassRequestData('ownerId'), 'id');
    
    }
    
    protected function executeAdd()
    {
        $requestData = $this->getData();
        $className = $this->getFullClassName();
        $document = new $className;
        $document = $this->setDatiDocument ($document, $requestData);
        
        $relatedDocument = $this->getRelatedDocument ();
        $relatedDocument = $relatedDocument->addOption ($document);
        
        $documentOk = $this->saveDocument($relatedDocument);
        $response = array ('success'=>true, 'message'=>'Record aggiunto con successo');
        return $response;   
    }
    
    /**
     *
     * @param type $attributo
     * @param type $data
     * @return type FDT\Metadata\Document\Attributi\DataSet
     */
    protected function setDatiDocument ($dataset, $data)
    {   
        $dataset->setValue ($data['value']);
        $dataset->setOrdine ($data['ordine']);
        
        $dataset = $this->manageTranslationsData ($dataset, $data);
        
        return  $dataset; 
    }
}
