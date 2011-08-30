<?php
namespace FDT\MetadataBundle\Document\Attributi;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @MongoDB\EmbeddedDocument
 */
class BaseAttributoValue
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /** 
    * @MongoDB\Boolean
    * @Assert\Type("bool")
    */
    private $isActive = true;
    
    /** 
    * @MongoDB\Boolean
    * @Assert\Type("bool")
    */
    private $inSearch= false;
    
    /** 
    * @MongoDB\Boolean
    * @Assert\Type("bool")
    */
    private $inQuickSearch = false;
    
    /** 
    * @MongoDB\Boolean
    * @Assert\Type("bool")
    */
    private $isPubblicable = true;
    
    /** 
    * @MongoDB\Boolean
    * @Assert\Type("bool")
    */
    private $isForConfiguration = false;
        
    /** 
    * @MongoDB\Boolean
    * @Assert\Type("bool")
    */
    private $mustBeTranslated = false;
    
    /** 
    * @MongoDB\String
    * @Assert\Type("string")
    * @Assert\NotBlank()
    */
    private $configId;
    
    /** 
    * @MongoDB\String
    * @Assert\Type("string")
    * @Assert\NotBlank()
    */
    private $attributoId;
    
     /** 
    * @MongoDB\String
    * @Assert\Type("string")
    * @Assert\NotBlank()
    */
    private $attributoTipo;
    
    /** 
    * @MongoDB\String
    * @Assert\Type("string")
    * @Assert\NotBlank()
    */
    private $uniqueSlug;
    
    /**
     * @MongoDB\Hash
     * @Assert\NotBlank()
     * @access private
     */
    private $slug = array ();
    
    /**
     * @MongoDB\Hash
     * @Assert\NotBlank()
     * @access private
     */
    private $name = array ();

    /**
     * @MongoDB\String
     * @Assert\NotBlank()
     * @var string
     */
    private $value;

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
    
    /**
     * Set isActive
     *
     * @param boolean $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * Get isActive
     *
     * @return boolean $isActive
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
    
    /**
     * Set $inSearch
     *
     * @param boolean $inSearch
     */
    public function setInSearch($inSearch)
    {
        $this->inSearch = $inSearch;
    }

    /**
     * Get $inSearch
     *
     * @return boolean $inSearch
     */
    public function getInSearch()
    {
        return $this->inSearch;
    }
    
    
     /**
     * Set $inQuickSearch
     *
     * @param boolean $inQuickSearch
     */
    public function setInQuickSearch($inQuickSearch)
    {
        $this->inQuickSearch = $inQuickSearch;
    }

    /**
     * Get $inQuickSearch
     *
     * @return boolean $inQuickSearch
     */
    public function getInQuickSearch()
    {
        return $this->inQuickSearch;
    }
    
    /**
     * Set $isPubblicable
     *
     * @param boolean $isPubblicable
     */
    public function setIsPubblicable($isPubblicable)
    {
        $this->isPubblicable = $isPubblicable;
    }

    /**
     * Get $isPubblicable
     *
     * @return boolean $isPubblicable
     */
    public function getIsPubblicable()
    {
        return $this->isPubblicable;
    }
    
     /**
     * Set $isForConfiguration
     *
     * @param boolean $isForConfiguration
     */
    public function setIsForConfiguration($isForConfiguration)
    {
        $this->isForConfiguration = $isForConfiguration;
    }

    /**
     * Get $isForConfiguration
     *
     * @return boolean $isForConfiguration
     */
    public function getIsForConfiguration()
    {
        return $this->isForConfiguration;
    }
    
    /**
     * Set $mustBeTranslated
     *
     * @param boolean $mustBeTranslated
     */
    public function setMustBeTranslated($mustBeTranslated)
    {
        $this->mustBeTranslated = $mustBeTranslated;
    }

    /**
     * Get $mustBeTranslated
     *
     * @return boolean $mustBeTranslated
     */
    public function getMustBeTranslated()
    {
        return $this->mustBeTranslated;
    }
    
     /**
     * Set $configId
     *
     * @param string $configId
     */
    public function setConfigId($configId)
    {
        $this->configId = $configId;
    }

    /**
     * Get $configId
     *
     * @return string $configId
     */
    public function getConfigId()
    {
        return $this->configId;
    }
    
    /**
     * Set $attributoId
     *
     * @param string $attributoId
     */
    public function setAttributoId($attributoId)
    {
        $this->attributoId = $attributoId;
    }

    /**
     * Get $attributoId
     *
     * @return string $attributoId
     */
    public function getAttributoId()
    {
        return $this->attributoId;
    }
    
    /**
     * Set $attributoTipo
     *
     * @param string $attributoTipo
     */
    public function setAttributoTipo($attributoTipo)
    {
        $this->attributoTipo = $attributoTipo;
    }

    /**
     * Get $attributoTipo
     *
     * @return string $attributoTipo
     */
    public function getAttributoTipo()
    {
        return $this->attributoTipo;
    }
    
    /**
     * Set $uniqueSlug
     *
     * @param string $uniqueSlug
     */
    public function setUniqueSlug($uniqueSlug)
    {
        $this->uniqueSlug = $uniqueSlug;
    }

    /**
     * Get $uniqueSlug
     *
     * @return string $uniqueSlug
     */
    public function getUniqueSlug()
    {
        return $this->uniqueSlug;
    }
    
    /**
     * Add $slugs
     *
     * @param array $slugs
     */
    public function addSlugs(array $slugs)
    {
        return $this->slug = $slugs;
    }
    
    /**
     * Add $names
     *
     * @param array $names
     */
    public function addNames(array $names)
    {
        return $this->name = $names;
    }
    
    /**
     * Set $value
     *
     * @param string $names
     */
    public function setValue($value)
    {
        return $this->value = $value;
    }
    
    /**
     * Get $value
     *
     */
    public function getValue()
    {
        return $this->value;
    }

    public function build(array $attributoData)
    {
        
        $this->addNames ($attributoData['name']);
        $this->addSlugs ($attributoData['slug']);
        $this->setConfigId ($attributoData['configId']);
        $this->setAttributoId ($attributoData['attributoId']);
        $this->setAttributoTipo ($attributoData['attributoTipo']);
        $this->setUniqueSlug ($attributoData['uniqueSlug']);
        $this->setValue ($attributoData['value']);
        //FLAGS
        $this->setIsActive ($attributoData['isActive']==1?true:false);
        $this->setInSearch ($attributoData['inSearch']==1?true:false);
        $this->setInQuickSearch ($attributoData['inQuickSearch']==1?true:false);
        $this->setIsPubblicable ($attributoData['isPubblicable']==1?true:false);
        $this->setIsForConfiguration ($attributoData['isForConfiguration']==1?true:false);
    }
    
    
}
