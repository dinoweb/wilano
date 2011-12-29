<?php
namespace FDT\MetadataBundle\Document\Attributi;

use FDT\MetadataBundle\Document\BaseRepository;
use FDT\MetadataBundle\Document\Attributi\DataSet;


class DataSetRepository extends BaseRepository
{    
    public function generateCursor(array $limit, array $filter = array())
    {
    
        $arrayFilter = $this->getFiltersArray ($filter);
        
        $queryBuilder = $this->createQueryBuilder()->limit ($limit['limit'])
                        ->skip($limit['skip'])
                        ->sort ('uniqueSlug', 'asc');
        
        if (count ($arrayFilter) > 0)
        {        
            foreach ($arrayFilter as $operator=>$arrayFieldValue)
            {
                switch ($operator) {
                                        case 'CN':
                                            foreach ($arrayFieldValue as $field=>$value)
                                            {
                                                $queryBuilder->field($field)->equals(new \MongoRegex('/.*'.$value.'.*/i'));
                                            }
                                         
                                        break;
                                    }
        
            }
        }
                        
        $cursor = $queryBuilder->getQuery()->execute();
                    
        $this->setCursor ($cursor);
        
        return $this;
    }       
}