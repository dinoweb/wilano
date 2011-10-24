<?php

namespace FDT\MetadataBundle\Services\Controller;

class ManageAttributi extends AbstractRestController
{
    protected function getFullClassName ()
    {
        return 'FDT\\MetadataBundle\\Document\\Attributi\\Attributo';    
    }
    
    /**
     *
     * @param type $attributo
     * @param type $data
     * @return type FDT\Metadata\Document\Attributi\Attributo
     */
    protected function setDatiDocument ($attributo, $data)
    {   
        $attributo->setUniqueName ($data['uniqueName']);
        $attributo->setIsActive ($data['isActive']);
        $attributo->setTipo ($data['tipo']);
        
        $attributo = $this->manageTranslationsData ($attributo, $data);
        
        return  $attributo; 
    }
}
