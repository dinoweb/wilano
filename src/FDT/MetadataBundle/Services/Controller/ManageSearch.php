<?php

namespace FDT\MetadataBundle\Services\Controller;

class ManageSearch extends AbstractRestController
{
    

    protected function getOwnerClassName ()
    {
        return 'FDT\\MetadataBundle\\Document\\'.$this->getRelatedClassRequestData ('ownerModel');       
    }
                
}
