<?php
namespace FDT\MetadataBundle\Document\Attributi;

use FDT\MetadataBundle\Document\BaseRepository;

class AttributiRepository extends BaseRepository
{    
    public function retriveRecords(array $limit)
    {
        $cursor = $this->createQueryBuilder()
                     ->limit ($limit['limit'])->skip($limit['skip'])
                     ->getQuery()
                     ->execute();
        
        
            
        return $cursor;
    }
}