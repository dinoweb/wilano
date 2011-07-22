<?php
namespace FDT\MetadataBundle\Document;

use Doctrine\ODM\MongoDB\DocumentRepository;
use FDT\MetadataBundle\Exception\ValidatorErrorException;


class BaseRepository extends DocumentRepository
{
    public function getByMyUniqueId($uniqueSlug, $field = 'uniqueSlug')
    {
        $cursor = $this->createQueryBuilder()
                     ->field($field)->equals($uniqueSlug)
                     ->getQuery()
                     ->execute();
        
        if ($cursor->count() == 1)
        {
        
            return $cursor->getSingleResult();
        
        }
        
        if ($cursor->count() > 1)
        {
        
            throw new DocumentNotUniqueException (sprintf('Il documento avente il campo %s uguale a %s non è unico', $field, $uniqueSlug));
        
        }
            
        return FALSE;
    }
    
 }