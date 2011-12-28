<?php

namespace FDT\MetadataBundle\Services\Controller;

class ManageSearch extends AbstractRestController
{
    

    protected function getFullClassName ()
    {
        return 'FDT\\MetadataBundle\\Document\\'.$this->getRelatedClassRequestData ('ownerType');       
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
