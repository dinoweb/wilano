<?php
namespace FDT\MetadataBundle\Document\Tipologie;

use Symfony\Component\Validator\Constraints as Assert;
use FDT\doctrineExtensions\NestedSet\Documents\BaseNode;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

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
 
 
class BaseTipologia implements BaseNode, Translatable
{
    
     /** @MongoDB\Id(strategy="AUTO") */
    private $id;
	    
    /**
     * @MongoDB\Int
     */
    private $level = 0;
    
    /**
     * @MongoDB\Int
     */
    private $index = 0;
    
    /** 
    * @MongoDB\String
    * @Gedmo\Translatable
    * @Assert\NotBlank()
    * 
    */
    private $name;
    
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
    * @MongoDB\String
    * @Assert\NotBlank()
    * 
    */
    private $uniqueName;
    
    
     /**
     * @MongoDB\String
     * @Gedmo\Slug(fields={"uniqueName"})
     */
    private $uniqueSlug;
    
    /**
     * @MongoDB\String
     * @Gedmo\Translatable
     */
    private $descrizione;
    
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
    * @Gedmo\Locale
    */
    protected $locale;
    
    /** @MongoDB\Boolean*/
    private $isActive = true;
    
    /** @MongoDB\Boolean*/
    private $isPrivate = false;
    
    /** @MongoDB\Boolean*/
    private $isConfigurable = false;
    
    /** @MongoDB\Boolean*/
    private $hasPeriod = false;
        
    
    /**
     * @MongoDB\ReferenceMany(targetDocument="FDT\MetadataBundle\Document\Attributi\Config", cascade="all", sort={"ordine"="asc"})
     *
     * @var array|ArrayCollection
     * @access protected
     */
    private $attributi = array();
    
    private $attributiTree = FALSE;
    
    public function __construct()
    {
        $this->ancestors = new ArrayCollection();
        $this->attributi = new ArrayCollection();
    }
    
    
    /**
     * initAttributiTree function. Inizializza la collection $attributiTree per il documento
     * 
     * @access private
     * @return void
     */
    private function initAttributiTree ()
    {
    
        if (!$this->attributiTree)
        {
            $this->attributiTree = new ArrayCollection();
             
        }
    
    }
    
    
    /**
     * addAttributiToTree function. Aggiunge gli attributi di un singolo documento alla lista degli attributi dell albero
     * 
     * @access private
     * @return void
     */
    private function addAttributiToTree ()
    {
    
        $attributi = $this->getAttributi ();
            
        if ($attributi->count() > 0)
        {
            foreach ($attributi as $attributo)
            {
                $this->addAttributiTree ($attributo);
            }
        } 
    
    
    
    }
    
    
    
    /**
     * getAttributiTree function.
     * 
     * @access public
     * @param bool $withParent (default: TRUE)
     * @return array collection di tutte le configurazioni di attributi, comprese quelle delle classi parent
     */
    public function getAttributiTree ($withParent = TRUE)
    {
        $this->initAttributiTree ();
        
        if ($withParent)
        {
            $parent = $this->getParent();
        
            if ($parent)
            {
                $attributiParent = $parent->getAttributiTree ();
                
                    if ($attributiParent->count() > 0)
                    {
                        foreach ($attributiParent as $attributo)
                        {
                            $this->addAttributiTree ($attributo);
                        }
                    }    
                
            }
        }
        
        $this->addAttributiToTree ();
                
        return  $this->attributiTree;
    
    }
    
    
    public function sortByOneKey($collection, $key, $asc = true)
    {
        $result = array();
        $values = array();
        $functionName = 'get'.ucfirst($key);
        
        $array = $collection->toArray ();
        foreach ($array as $id => $value)
        {
            $values[$id] = method_exists($value, $functionName) ? $value->$functionName() : '';
        }
        
        if ($asc) 
        {
            asort($values);
        }
        else 
        {
            arsort($values);
        }
        
        foreach ($values as $key => $value)
        {
            $result[$key] = $array[$key];
        }
        
        return new ArrayCollection ($result);
    }
    
    
    /**
     * getAttributi function.
     * 
     * @access public
     * @return la configurazione degli attributi associati a questo documento
     */
    public function getAttributi ()
    {
        
        return  $this->sortByOneKey($this->attributi, 'ordine', $asc = true);    
        //return $this->attributi;
    
    }
    
    
    
    /**
     * getAttributoConfig function.
     * 
     * @access public
     * @param mixed $uniqueSlug
     * @return Attributi\Config instance
     */
    public function getAttributoConfig ($uniqueSlug)
    {
        $attributi = $this->getAttributiTree ();
        
        return $attributi[$uniqueSlug];
    
    }
    
    
    /**
     * getAttributo function.
     * 
     * @access public
     * @param mixed $uniqueSlug
     * @return Attributi\Attributo instance
     */
    public function getAttributo ($uniqueSlug)
    {
        $attributoConfig = $this->getAttributoConfig ($uniqueSlug);
        
        if (is_null($attributoConfig))
        {
        
            return NULL;
            
        }
        
        return $attributoConfig->getAttributo ();
    
    }
    
    
    /**
     * addAttributiTree function.
     * 
     * @access public
     * @param mixed $attibutoConf una configurazione attributo associabile
     * @return void
     */
    public function addAttributiTree ($attibutoConf)
    {
        $uniqueSlug = $attibutoConf->getAttributo ()->getUniqueSlug();
            
        $this->attributiTree->set ($uniqueSlug, $attibutoConf);
    
    }
    
    
    /**
     * addAttributi function.
     * 
     * @access public
     * @param mixed $attibutoConf una configurazione attributo associabile
     * @return void
     */
    public function addAttributi (\FDT\MetadataBundle\Document\Attributi\Config $attibutoConf)
    {            
        $this->attributi->add ($attibutoConf);
    
    }
    
    //METODI NECESSARI ALLA GESTIONE DEL TREE
    public function setIndex($index)
    {	
        $this->index = $index;
    }

    
    
    public function getIndex()
    {	
        return $this->index;
    }
    
    
    public function getLevel()
    {	
        return $this->level;
    }
	            
    
    public function getId()
    {
        return $this->id;
    }
    
    public function clearAncestors ()
    {
    
        $this->ancestors = new ArrayCollection (array());
    
    }
    
    public function removeAncestor ($ancestor)
    {
        return $this->getAncestors()->removeElement($ancestor);
    }
    
    public function addAncestor($ancestor)
    {
        if ($this->ancestors->contains($ancestor))
        {
            return false;
        }
        $this->ancestors->add($ancestor);
    }

    public function getAncestors()
    {
        return $this->ancestors;
    }
    
    public function getRoot()
    {
        if ($this->getLevel() == 0) {
            return $this;
        }
        
        foreach ($this->getAncestors() as $key => $ancestor) {
            if ($ancestor->getLevel() == 0) {
                return $ancestor;
            }
        }
    }
    
    public function removeParent()
    {
        $this->parent = NULL;
    }
    
    public function setParent($parent)
    {       
       $this->parent = $parent;
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
       return $this->getId();
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
     * setDescrizione function.
     * 
     * @access public
     * @param mixed $name
     * @return void
     */
    public function setDescrizione ($descrizione)
    {
    
        $this->descrizione = $descrizione;
    
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
     *
     * @return string uniqueName
     * @author Lorenzo Caldara
     */
    public function getUniqueName()
    {
        return $this->uniqueName;
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
    
    
    
    /**
     * modifica la lingua in cui salvare il documento
     *
     * @param string $locale 
     * @return void
     * @author Lorenzo Caldara
     */
    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }
    
    public function getType($returnNamespace = FALSE)
    {
        $calledClass =  get_called_class();
        if ($returnNamespace) {
            return $calledClass;
        }
        
        $arrayCalledClass = explode('\\', $calledClass);
        return $arrayCalledClass[count($arrayCalledClass) - 1];
    }
    
    public function setIsActive($value)
    {
        $this->isActive = $value;
    }
    
    public function getIsActive()
    {
        return $this->isActive;
    }
    
    public function setIsPrivate($value)
    {
        $this->isPrivate = $value;
    }
    
    public function getIsPrivate()
    {
        return $this->isPrivate;
    }
    
    public function setIsConfigurable($value)
    {
        $this->isConfigurable = $value;
    }
    
    public function getIsConfigurable()
    {
        return $this->isConfigurable;
    }
    
    public function setHasPeriod($value)
    {
        $this->hasPeriod = $value;
    }
    
    public function getHasPeriod()
    {
        return $this->hasPeriod;
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

