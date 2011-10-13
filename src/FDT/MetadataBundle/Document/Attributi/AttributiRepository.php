<?php
namespace FDT\MetadataBundle\Document\Attributi;

use FDT\MetadataBundle\Document\BaseRepository;

class AttributiRepository extends BaseRepository
{    
    
    public function generateCursor(array $limit)
    {
        $cursor = $this->createQueryBuilder()
                     ->limit ($limit['limit'])->skip($limit['skip'])
                     ->sort ('updated', 'desc')
                     ->getQuery()
                     ->execute();
        
        
            
        $this->setCursor ($cursor);
        
        return $this;
        
    }
    
    
    
    
}