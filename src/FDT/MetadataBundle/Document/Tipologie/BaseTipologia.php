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
     * @Gedmo\Slug(updatable=false)
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
    * @Gedmo\Locale
    */
    protected $locale;
    
    
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
    public function addAttributi ($attibutoConf)
    {            
        $this->attributi->add ($attibutoConf);
    
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
    
    public function getSlug()
    {
        return $this->slug;
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

}

