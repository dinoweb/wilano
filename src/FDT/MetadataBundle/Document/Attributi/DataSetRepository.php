<?php
namespace FDT\MetadataBundle\Document\Attributi;

use FDT\MetadataBundle\Document\BaseRepository;
use FDT\MetadataBundle\Document\Attributi\DataSet;


class DataSetRepository extends BaseRepository
{    
    public function generateCursor(array $limit)
    {
        $cursor = $this->createQueryBuilder()
                     ->limit ($limit['limit'])->skip($limit['skip'])
                     ->sort ('uniqueSlug', 'asc')
                     ->getQuery()
                     ->execute();
        
        
            
        $this->setCursor ($cursor);
        
        return $this;
        
    }
}