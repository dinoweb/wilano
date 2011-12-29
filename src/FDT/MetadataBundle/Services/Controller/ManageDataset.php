<?php

namespace FDT\MetadataBundle\Services\Controller;

class ManageDataset extends AbstractRestController
{
    protected function getOwnerClassName ()
    {
        return 'FDT\\MetadataBundle\\Document\\Attributi\\DataSet';    
    }
}
