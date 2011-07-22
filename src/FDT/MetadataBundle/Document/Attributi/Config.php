<?php
namespace FDT\MetadataBundle\Document\Attributi;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @MongoDB\Document(collection="attributi.config"))
 */
 
class Config
{
    /** @MongoDB\Id(strategy="AUTO") */
    private $id;
    
    /** 
    * @MongoDB\Int
    * @Assert\Type("int")
    */ 
    private $ordine = 0;
    
    /** 
    * @MongoDB\Boolean
    * @Assert\Type("bool")
    */
    private $isActive = true;
    
    /** 
    * @MongoDB\Boolean
    * @Assert\Type("bool")
    */
    private $isObligatory = true;
    
    /** 
    * @MongoDB\Boolean
    * @Assert\Type("bool")
    */
    private $inSearch = true;
    
    /** 
    * @MongoDB\Boolean
    * @Assert\Type("bool")
    */
    private $inQuickSearch = true;
    
    /** 
    * @MongoDB\Boolean
    * @Assert\Type("bool")
    */
    private $hasTranslation = false;
    
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
     * @MongoDB\ReferenceOne(targetDocument="Attributo")
     * @Assert\NotBlank()
     * @access private
     */
    private $attributo;
    

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
        
    /**
     * Add attributo
     *
     * @param FDT\MetadataBundle\Document\Attributi\Attributo $attributo
     */
    public function addAttributo(\FDT\MetadataBundle\Document\Attributi\Attributo $attributo)
    {
        $this->attributo = $attributo;
    }

    /**
     * Get attributi
     *
     * @return Doctrine\Common\Collections\Collection $attributo
     */
    public function getAttributo()
    {
        return $this->attributo;
    }
}