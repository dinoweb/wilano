<?php
namespace FDT\MetadataBundle\Document\Attributi;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

/**
 * @MongoDB\Document(collection="option", repositoryClass="FDT\MetadataBundle\Document\Attributi\OptionRepository"))
 * @Gedmo\TranslationEntity(class="FDT\MetadataBundle\Document\Attributi\OptionTranslation")
 */
class Option
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /** 
    * @MongoDB\String
    * @Gedmo\Translatable
    * @Assert\NotBlank()
    * 
    */
    protected $name;
    
    /**
     * @MongoDB\String
     * @Gedmo\Translatable
     * @Gedmo\Slug(fields={"name"}, updatable=false)
     */
    protected $slug;

    /**
     * @mongodb\String
     * @var string
     */
    protected $value;
    
    /** 
    * @MongoDB\Int
    * @Assert\Type("int")
    */ 
    private $ordine = 0;
    
    /**
     * @Gedmo\Locale
     */
    private $locale;

    public function  __toString()
    {
        return (string) $this->getValue();
    }
    
    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return Option $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
    
    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
    
    /**
     *
     * @param int $ordine 
     * @return void
     * @author Lorenzo Caldara
     */
    public function setOrdine($ordine)
    {
        $this->ordine = $ordine;
    }
    
    /**
     * @return int
     */
    public function getOrdine()
    {
        return $this->ordine;
    }
    
}
