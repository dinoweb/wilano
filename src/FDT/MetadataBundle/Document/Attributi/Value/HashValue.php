<?php
namespace FDT\MetadataBundle\Document\Attributi\Value;

use FDT\MetadataBundle\Document\Attributi\BaseAttributoValue;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
/**
 * @MongoDB\Document
 */
class HashValue extends BaseAttributoValue
{
    
    /**
     * @MongoDB\Hash
     * @Assert\NotBlank()
     * @var array
     */
    protected $value = array ();
    
    public function setValue($value)
    {
        $this->value = $value;
    }
    
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