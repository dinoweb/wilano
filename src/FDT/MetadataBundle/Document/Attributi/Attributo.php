<?php
namespace FDT\MetadataBundle\Document\Attributi;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(collection="attributi")
 */
 
class Attributo
{
    /** @MongoDB\Id(strategy="AUTO") */
    private $id;
    
    /** @MongoDB\String*/
    private $name;
    
    /** @MongoDB\String*/
    private $visibleName;
    
    /** @MongoDB\String*/
    private $descrizione;
    
    /** @MongoDB\String*/
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

    /**
     * Set visibleName
     *
     * @param string $visibleName
     */
    public function setVisibleName($visibleName)
    {
        $this->visibleName = $visibleName;
    }

    /**
     * Get visibleName
     *
     * @return string $visibleName
     */
    public function getVisibleName()
    {
        return $this->visibleName;
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