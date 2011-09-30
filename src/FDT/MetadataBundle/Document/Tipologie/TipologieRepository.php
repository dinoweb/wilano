<?php
namespace FDT\MetadataBundle\Document\Tipologie;

use FDT\MetadataBundle\Document\BaseRepository;


class TipologieRepository extends BaseRepository
{
    public function getRoots()
    {
        $cursor = $this->createQueryBuilder()
                     ->field('level')->equals(0)
                     ->getQuery()
                     ->execute();
        
        
            
        return $cursor;
    }
    
}