<?php
namespace FDT\MetadataBundle\Document\Tipologie;

use Symfony\Component\Validator\Constraints as Assert;
use FDT\doctrineExtensions\NestedSet\Documents\BaseNode;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @MongoDB\Document(collection="tipologie", repositoryClass="FDT\MetadataBundle\Document\Tipologie\TipologieRepository")
 * @MongoDB\InheritanceType("SINGLE_COLLECTION")
 * @MongoDB\DiscriminatorField(fieldName="type")
 * @MongoDB\DiscriminatorMap({
 *                               "prodotti"="Prodotti",
 *                               "schede"="Schede"
 *                               
 *                           })
 *@Gedmo\TranslationEntity(class="FDT\MetadataBundle\Document\Tipologie\TipologiaTranslation")
 */
 
 
class BaseTipologia implements BaseNode
{
    
     /** @MongoDB\Id(strategy="AUTO") */
    private $id;
	    
    /**
     * @MongoDB\Int
     */
    private $level;
    
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
    * @Gedmo\Translatable
    * @Gedmo\Sluggable(slugField="uniqueSlug")
    * @Assert\NotBlank()
    * 
    */
    private $uniqueName;
    
    
    /**
     * @MongoDB\String
     * @Gedmo\Translatable
     * @Gedmo\Slug
     */
    private $slug;
    
     /**
     * @MongoDB\String
     * @Gedmo\Slug
     */
    private $uniqueSlug;
    
    
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
     * @MongoDB\ReferenceMany(discriminatorField="type")
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
    public function addMetadata ($metadata)
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
     * setUniqueName function.
     * 
     * @access public
     * @param mixed $uniqueName
     * @return void
     */
    public function setUniqueName ($uniqueName)
    {
    
        $this->uniqueName = $uniqueName;
    
    }
    
    public function getUniqueSlug()
    {
        return $this->uniqueSlug;
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
    
    public function getSlug()
    {
        return $this->slug;
    }

}

