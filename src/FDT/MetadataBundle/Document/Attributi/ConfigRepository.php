<?php
namespace FDT\MetadataBundle\Document\Attributi;

use FDT\MetadataBundle\Document\BaseRepository;

class ConfigRepository extends BaseRepository
{    
    
    public function generateCursor(array $limit)
    {
        $cursor = $this->createQueryBuilder()
                     ->limit ($limit['limit'])->skip($limit['skip'])
                     ->sort ('ordine', 'asc')
                     ->getQuery()
                     ->execute();
        
        
            
        $this->setCursor ($cursor);
        
        return $this;
        
    }
    
    
    
    
}