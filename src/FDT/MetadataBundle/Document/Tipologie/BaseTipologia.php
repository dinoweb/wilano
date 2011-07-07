<?php
namespace FDT\MetadataBundle\Document\Tipologie;

use FDT\doctrineExtensions\NestedSet\Documents\BaseNode;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @MongoDB\Document(collection="tipologie")
 * @MongoDB\InheritanceType("SINGLE_COLLECTION")
 * @MongoDB\DiscriminatorField(fieldName="type")
 * @MongoDB\DiscriminatorMap({
 *                               "prodotti"="Prodotti",
 *                               "schede"="Schede"
 *                               
 *                           })
 */
 
 
class BaseTipologia implements BaseNode
{
    
     /** @MongoDB\Id(strategy="AUTO") */
    private $id;
	    
    /**
     * @MongoDB\Int
     */
    private $level;
    
    /** @MongoDB\String */
    private $name;
    
    /**
     * @MongoDB\ReferenceMany(targetDocument="BaseTipologia", cascade="all")
     * @MongoDB\Index
     */
    private $ancestors = array();
    
    /**
     * @MongoDB\ReferenceOne(targetDocument="BaseTipologia", cascade="all")
     * @MongoDB\Index
     */
    private $parent;
    
    
    /**
     * @MongoDB\EmbedMany(discriminatorField="type")
     *
     * @var array|ArrayCollection
     * @access protected
     */
    private $metadata = array();
    
    public function __construct()
    {
        $this->ancestors = new ArrayCollection();
        $this->metadata = new ArrayCollection();
    }
    
    public function getMetadata ()
    {
    
        return $this->metadata;
    
    }
    
    
    /**
     * setMetadata function.
     * 
     * @access public
     * @param mixed $metadata una categoria associabile a contenuti di questa tipologia o un attributo associabile
     * @return void
     */
    public function setMetadata ($metadata)
    {
    
        $this->metadata[] = $metadata;
    
    }
    
    //METODI NECESSARI ALLA GESTIONE DEL TREE
    
    public function getLevel()
    {	
        return $this->level;
    }
	            
    
    public function getId()
    {
        return $this->id;
    }
    
    public function addAncestor($ancestor)
    {
        $this->ancestors[] = $ancestor;
    }

    public function getAncestors()
    {
        return $this->ancestors;
    }
    
    public function setParent($ancestor)
    {       
       $this->parent = $ancestor;
    }
    
    public function getParent()
    {
       return $this->parent;
    }
    
    public function setLevel()
    {	
        $this->level = count ($this->getAncestors());
        
    }
    
    public function getStringForPath()
    {
       return $this->getName();
    }
           
    /**
     * setName function.
     * 
     * @access public
     * @param mixed $name
     * @return void
     */
    public function setName ($name)
    {
    
        $this->name = $name;
    
    }
    
    /**
     * getName function.
     * 
     * @access public
     * @return string name
     */
    public function getName ()
    {
    
        return $this->name;
    
    }

}

