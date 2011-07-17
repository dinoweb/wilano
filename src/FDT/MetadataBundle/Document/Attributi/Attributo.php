<?php
namespace FDT\MetadataBundle\Document\Attributi;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Sluggable\Util;

/**
 * @MongoDB\Document(collection="attributi")
 * @Gedmo\TranslationEntity(class="FDT\MetadataBundle\Document\Attributi\AttributoTranslation")
 */
 
class Attributo
{
    /** @MongoDB\Id(strategy="AUTO") */
    private $id;
    
    /** 
    * @MongoDB\String
    * @Gedmo\Translatable
    * @Gedmo\Sluggable(slugField="slug")
    * @Assert\NotBlank()
    * 
    */
    private $name;
    
    /** 
    * @MongoDB\String
    * @Gedmo\Sluggable(slugField="uniqueSlug")
    * @Assert\NotBlank()
    */
    private $uniqueName;
    
    /**
     * @MongoDB\String
     * @Gedmo\Slug
     */
    private $uniqueSlug;
    
    /**
     * @MongoDB\String
     * @Gedmo\Translatable
     * @Gedmo\Slug
     */
    private $slug;
    
    /** 
    * @MongoDB\String
    * @Gedmo\Translatable
    */
    private $descrizione;
    
    /** 
    * @MongoDB\String
    * @Assert\NotBlank()
    */
    private $tipo;
    
    /** @MongoDB\Boolean*/
    private $isActive = true;
      

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
     * Set name
     *
     * @param string $nome
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string $nome
     */
    public function getName()
    {
        return $this->name;
    }
    
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set uniqueName
     *
     * @param string $uniqueName
     */
    public function setUniqueName($uniqueName)
    {
        $this->uniqueName = $uniqueName;
    }

    /**
     * Get uniqueName
     *
     * @return string $uniqueName
     */
    public function getUniqueName()
    {
        return $this->uniqueName;
    }
      
    public function getUniqueSlug()
    {
        return $this->uniqueSlug;
    }

    /**
     * Set descrizione
     *
     * @param string $descrizione
     */
    public function setDescrizione($descrizione)
    {
        $this->descrizione = $descrizione;
    }

    /**
     * Get descrizione
     *
     * @return string $descrizione
     */
    public function getDescrizione()
    {
        return $this->descrizione;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * Get tipo
     *
     * @return string $tipo
     */
    public function getTipo()
    {
        return $this->tipo;
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
    public function isActive()
    {
        return $this->isActive;
    }

}