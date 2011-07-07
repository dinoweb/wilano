<?php
namespace FDT\MetadataBundle\Document\Attributi;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
 
class Config
{
    /** @MongoDB\Id(strategy="AUTO") */
    private $id;
    
    /** @MongoDB\Int*/ 
    private $ordine;
    
    /** @MongoDB\Boolean*/
    private $isActive = true;
    
    /** @MongoDB\Boolean*/
    private $isObligatory = true;
    
    /** @MongoDB\Boolean*/
    private $inSearch = true;
    
    /** @MongoDB\Boolean*/
    private $inQuickSearch = true;
    
    /** @MongoDB\Boolean*/
    private $hasTranslation = false;
    
    /** @MongoDB\Boolean*/
    private $isPubblicable = true;
    
    /** @MongoDB\Boolean*/
    private $isForConfiguration = false;
    
    /**
     * @MongoDB\ReferenceMany(targetDocument="Attributo", discriminatorField="type")
     *
     * @var array|ArrayCollection
     * @access protected
     */
    protected $attributi = array();
    

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ordine
     *
     * @param int $ordine
     */
    public function setOrdine($ordine)
    {
        $this->ordine = $ordine;
    }

    /**
     * Get ordine
     *
     * @return int $ordine
     */
    public function getOrdine()
    {
        return $this->ordine;
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
     * Set isObligatory
     *
     * @param boolean $isObligatory
     */
    public function setIsObligatory($isObligatory)
    {
        $this->isObligatory = $isObligatory;
    }

    /**
     * Get isObligatory
     *
     * @return boolean $isObligatory
     */
    public function getIsObligatory()
    {
        return $this->isObligatory;
    }

    /**
     * Set inSearch
     *
     * @param boolean $inSearch
     */
    public function setInSearch($inSearch)
    {
        $this->inSearch = $inSearch;
    }

    /**
     * Get inSearch
     *
     * @return boolean $inSearch
     */
    public function getInSearch()
    {
        return $this->inSearch;
    }

    /**
     * Set inQuickSearch
     *
     * @param boolean $inQuickSearch
     */
    public function setInQuickSearch($inQuickSearch)
    {
        $this->inQuickSearch = $inQuickSearch;
    }

    /**
     * Get inQuickSearch
     *
     * @return boolean $inQuickSearch
     */
    public function getInQuickSearch()
    {
        return $this->inQuickSearch;
    }

    /**
     * Set hasTranslation
     *
     * @param boolean $hasTranslation
     */
    public function setHasTranslation($hasTranslation)
    {
        $this->hasTranslation = $hasTranslation;
    }

    /**
     * Get hasTranslation
     *
     * @return boolean $hasTranslation
     */
    public function getHasTranslation()
    {
        return $this->hasTranslation;
    }

    /**
     * Set isPubblicable
     *
     * @param boolean $isPubblicable
     */
    public function setIsPubblicable($isPubblicable)
    {
        $this->isPubblicable = $isPubblicable;
    }

    /**
     * Get isPubblicable
     *
     * @return boolean $isPubblicable
     */
    public function getIsPubblicable()
    {
        return $this->isPubblicable;
    }

    /**
     * Set isForConfiguration
     *
     * @param boolean $isForConfiguration
     */
    public function setIsForConfiguration($isForConfiguration)
    {
        $this->isForConfiguration = $isForConfiguration;
    }

    /**
     * Get isForConfiguration
     *
     * @return boolean $isForConfiguration
     */
    public function getIsForConfiguration()
    {
        return $this->isForConfiguration;
    }
    public function __construct()
    {
        $this->attributi = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add attributi
     *
     * @param FDT\MetadataBundle\Document\Attributi\Attributo $attributi
     */
    public function addAttributi(\FDT\MetadataBundle\Document\Attributi\Attributo $attributi)
    {
        $this->attributi[] = $attributi;
    }

    /**
     * Get attributi
     *
     * @return Doctrine\Common\Collections\Collection $attributi
     */
    public function getAttributi()
    {
        return $this->attributi;
    }
}