<?php

namespace FDT\MetadataBundle\Services\Controller;

class ManageDataset extends AbstractRestController
{
    protected function getFullClassName ()
    {
        return 'FDT\\MetadataBundle\\Document\\Attributi\\DataSet';    
    }
    
    /**
     *
     * @param type $attributo
     * @param type $data
     * @return type FDT\Metadata\Document\Attributi\DataSet
     */
    protected function setDatiDocument ($dataset, $data)
    {   
        $dataset->setUniqueName ($data['uniqueName']);
        
        $dataset = $this->manageTranslationsData ($dataset, $data);
        
        return  $dataset; 
    }
}
