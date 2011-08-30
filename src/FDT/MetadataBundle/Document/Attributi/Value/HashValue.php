<?php
namespace FDT\MetadataBundle\Document\Attributi\Value;

use FDT\MetadataBundle\Document\Attributi\BaseAttributoValue;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
/**
 * @MongoDB\EmbeddedDocument
 */
class HashValue extends BaseAttributoValue
{
    
    /** @MongoDB\Hash */
    private $value;
    
    /**
     * Ritorna il nome nella lingua richiesta se esiste, se no ritorna la prima traduzione che trova
     *
     * @param string $locale 
     * @return string $value
     * @author Lorenzo Caldara
     */
    public function getValueLocale($locale)
    {
        $values = $this->getValue();
        if (isset($values[$locale])) {
            return $values[$locale];
        }
        
        foreach ($values as $key => $value) {
            return $value;
        }
        
    }
    

}