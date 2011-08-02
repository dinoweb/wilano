<?php
namespace FDT\MetadataBundle\Document\Contenuti;

use FDT\doctrineExtensions\NestedSet\Documents\BaseNode;
use FDT\MetadataBundle\Document\Tipologie\BaseTipologia;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 * @MongoDB\InheritanceType("COLLECTION_PER_CLASS")
 */
 
 
class BaseContenuto implements BaseNode
{
    //PROPRIETA PER TREE
    
    /** @MongoDB\Id(strategy="INCREMENT") */
    private $id;
    
    /**
     * @MongoDB\Int
     */
    private $level;
    
    /**
     * @MongoDB\ReferenceMany(targetDocument="BaseContenuto", cascade="all")
     * @MongoDB\Index
     */
    private $ancestors = array();
    
    /**
     * @MongoDB\ReferenceOne(targetDocument="BaseContenuto", cascade="all")
     * @MongoDB\Index
     */
    private $parent;
    
    //FINE PROPRIETA PER TREE
    
    /** 
    * @MongoDB\Boolean
    * @Assert\Type("bool")
    */
    private $isActive = true;
    
    /**
     * @MongoDB\ReferenceOne(targetDocument="FDT\MetadataBundle\Document\Tipologie\BaseTipologia")
     * @Assert\NotBlank()
     * @access private
     */
    private $tipologia;
    
    /**
     * @var timestamp $created
     *
     * @MongoDB\Date
     * @Gedmo\Timestampable(on="create")
     */
    private $created;

    /**
     * @var date $updated
     *
     * @MongoDB\Date
     * @Gedmo\Timestampable(on="update")
     */
    private $updated;
    
    /**
     * @MongoDB\Hash
     * @Assert\NotBlank()
     * @access private
     */
    private $name = array ();
    
    /**
    * @MongoDB\EmbedMany(targetDocument="FDT\MetadataBundle\Document\Attributi\BaseAttributoValue")
    */
    private $attributiValues = array();
    
    public function __construct()
    {
        $this->ancestors = new ArrayCollection();
        $this->attributiValue = new ArrayCollection();
    }
    
    public function setNames(array $nameWithTranslation)
    {
        $this->name = $nameWithTranslation;
    }
    
    public function addAttributoValue(\FDT\MetadataBundle\Document\Attributi\BaseAttributoValue $attributoValue)
    {
        $this->attributiValues[] = $attributoValue;
    }
    
    public function setTipologia(BaseTipologia $tipologia)
    {
        $this->tipologia = $tipologia;
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
        $this->ancestors->add($ancestor);
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
       return $this->getSlug();
    }
    
    public function getCreated()
    {
        return $this->created;
    }

    public function getUpdated()
    {
        return $this->updated;
    }
    
    


}
