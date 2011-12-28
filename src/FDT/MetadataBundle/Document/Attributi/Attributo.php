<?php
namespace FDT\MetadataBundle\Document\Attributi;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use FDT\MetadataBundle\Validator as MyAssert;

/**
 * @MongoDB\Document(collection="attributi", repositoryClass="FDT\MetadataBundle\Document\Attributi\AttributiRepository")
 * @Gedmo\TranslationEntity(class="FDT\MetadataBundle\Document\Attributi\AttributoTranslation")
 */
 
class Attributo implements Translatable
{
    /** @MongoDB\Id(strategy="AUTO") */
    private $id;
    
    /** 
    * @MongoDB\String
    * @Gedmo\Translatable
    * @Assert\NotBlank()
    * 
    */
    private $name;
    
    /** 
    * @MongoDB\String
    * @Assert\NotBlank()
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
     * @Gedmo\Slug(fields={"name"}, updatable=false)
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
    * @Assert\Choice(callback = {"\FDT\MetadataBundle\Utilities\Attributi\AttributiCallbacks", "getTypes"})
    */
    private $tipo;
    
    /** @MongoDB\Boolean*/
    private $isActive = true;
    
    /**
     * @Gedmo\Locale
     */
    private $locale;
    
    /**
     * @MongoDB\ReferenceOne(targetDocument="DataSet", cascade="all")
     * @MyAssert\DataSetIsOk()
     * @access private
     */
    private $dataSet;
    
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
    
    public function getSlug($lang = FALSE)
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
    
    /**
     * Add dataset
     *
     * @param FDT\MetadataBundle\Document\Attributi\Attributo $attributo
     */
    public function addDataset(\FDT\MetadataBundle\Document\Attributi\DataSet $dataSet)
    {
        $this->dataSet = $dataSet;
    }
    
    public function getDataset()
    {
        return $this->dataSet;
    }
    
    public function getOptions($toArray = TRUE, $indexBy = 'slug')
    {
        if ($this->hasDataset()) {
            return $this->getDataset()->getOptions($toArray, $indexBy);
        }
    }
    
    public function hasDataset()
    {
        if ($this->getDataset()) {
            return TRUE;
        }
        
        return FALSE;
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