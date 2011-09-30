<?php
namespace FDT\MetadataBundle\Document\Attributi;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use FDT\MetadataBundle\Exception\DatasetNoOptionsException;

/**
 * @MongoDB\Document(collection="dataset", repositoryClass="FDT\MetadataBundle\Document\Attributi\DataSetRepository"))
 * @Gedmo\TranslationEntity(class="FDT\MetadataBundle\Document\Attributi\DataSetTranslation")
 */
 
class DataSet implements Translatable
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
    * @Assert\NotBlank()
    */
    private $descrizione;
    
    
    /**
     * @Gedmo\Locale
     */
    private $locale;
    
    /**
    * @MongoDB\EmbedMany(targetDocument="FDT\MetadataBundle\Document\Attributi\Option")
    */
    protected $options = array();
    
    public function __construct()
    {
        $this->options = new ArrayCollection();
    }
      

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
    
    public function getOptions($toArray = FALSE, $indexBy = 'slug')
    {
        if (count($this->options) <= 0) {
            throw new DatasetNoOptionsException(sprintf('Il dataset %s non contine opzioni', $this->getName()));
            
        }
        $optionsArrayCollection = $this->sortByOneKey($this->options, 'ordine', $asc = true);
        if ($toArray) {
            $arrayOptions = array ();
            $functionName = 'get'.ucfirst($indexBy);
            foreach ($optionsArrayCollection as $key => $value) {
                $arrayKey = method_exists($value, $functionName) ? $value->$functionName() : $key;
                $arrayOptions[$arrayKey] = array ('name'=>$value->getName(), 'value'=>$value->getValue());
            }
            return $arrayOptions;
        }
        return  $optionsArrayCollection;
    }

    public function setOptions(ArrayCollection $options)
    {
        $this->options = $options;

        return $this;
    }

    public function addOption(Option $option)
    {
        if (!$this->hasOption($option)) {
            $this->options[] = $option;
        }

        return $this;
    }

    public function removeOption(Option $option)
    {
        return $this->options->removeElement($option);
    }

    public function getOption(Option $option)
    {
        $key = array_search($option, $this->options->toArray(), true);

        if ($key !== false) {
            return $this->options->get($key);
        }
        return false;
    }

    public function hasOption(Option $option)
    {
        $option = $this->getOption($option);
        
        if ($option)
        {
            return true;
        }
        
        return false;
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
    
}