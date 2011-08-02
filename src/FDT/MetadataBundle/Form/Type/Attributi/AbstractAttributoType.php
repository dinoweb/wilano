<?php
namespace FDT\MetadataBundle\Form\Type\Attributi;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\CallbackValidator;
use Symfony\Component\Form\FormError;
use FDT\MetadataBundle\Document\Attributi\Config;
use FDT\MetadataBundle\Services\AttributiTypeManager;



/**
* La base per ciascun form
*/
abstract class AbstractAttributoType extends AbstractType
{
    /**
     * @var FDT\MetadataBundle\Document\Attributi\Config
     */
    private $config;
    
    /**
     * @var FDT\MetadataBundle\Services\AttributiTypeManager
     */
    private $attributiTypeManager;
    
    /**
     * @param Config $config 
     * @param AttributiTypeManager $attributiTypeManager 
     * @author Lorenzo Caldara
     */
    function __construct(Config $config, AttributiTypeManager $attributiTypeManager)
    {
        $this->config = $config;
        $this->attributiTypeManager = $attributiTypeManager;
    }
    
    /**
     * @return FDT\MetadataBundle\Services\AttributiTypeManager
     * @author Lorenzo Caldara
     */
    protected function getAttributiTypeManager()
    {
        return ($this->attributiTypeManager);
    }
    
    protected function getLanguages()
    {
        return $this->getAttributiTypeManager()->getLanguages();
    }
    
    protected function attributoMusBeTranslated()
    {
        return $this->getAttributiTypeManager()->isTranslatable ($this->getAttributo ()->getTipo());
    }
    
    protected function getDocumentManager()
    {
        return $this->getAttributiTypeManager()->getDocumentManager();
    }
    
    
    /**
     * @return FDT\MetadataBundle\Document\Attributi\Config
     *
     * @author Lorenzo Caldara
     */
    public function getConfig ()
    {
        return ($this->config);
    }
    
    /**
     * @return FDT\MetadataBundle\Document\Attributi\Attributo
     *
     * @author Lorenzo Caldara
     */
    protected function getAttributo ()
    {
        return $this->getConfig ()->getAttributo();        
    }
    
    private function getTranslation($language, $field)
    {
        $repository = $this->getDocumentManager()->getRepository('FDT\MetadataBundle\Document\Attributi\AttributoTranslation');
        $translations = $repository->findTranslations($this->getAttributo ());
        
        if (isset ($translations[$language][$field])) {
            return $translations[$language][$field];
        }
        
        foreach ($this->getLanguages() as $key => $value) {
            if (isset ($translations[$key][$field])) {
                return $translations[$key][$field];
            }
        }
                
        
        
    }
    
    private function getFormForTranslatedField($field, FormBuilder $builder)
    {
       $arrayName = array();
       $builder->add($field, 'form', array ('required' => true, 'error_bubbling'=>true));
       foreach ($this->getLanguages() as $key => $value) {
            $builder->get($field)->add($key, 'hidden', array ('data'=>$this->getTranslation($key, $field), 'required' => true, 'read_only' => true)); 
            
       }
       return $builder;

    }
    
    /**
     * Crea i campi di default per ogni attributo - Si tratta dei campi contenenti i parametri di configurazione dell'attributo
     *
     * @param FormBuilder $builder 
     * @return FormBuilder
     * @author Lorenzo Caldara
     */
    protected function buildBaseFields(FormBuilder $builder)
    {
        $builder->add ('isActive', 'hidden', array (
                                                    'data' => $this->config->getIsActive(),
                                                    'read_only' => true
                                                    
                                                    )
                      
                      );
                      
        $builder->add ('inSearch', 'hidden', array (
                                                    'data' => $this->config->getInSearch(),
                                                    'read_only' => true
                                                    
                                                    )
                      
                      );
        
        $builder->add ('inQuickSearch', 'hidden', array (
                                                    'data' => $this->config->getInQuickSearch(),
                                                    'read_only' => true
                                                    
                                                    )
                      
                      );
        
        $builder->add ('isPubblicable', 'hidden', array (
                                                    'data' => $this->config->getIsPubblicable(),
                                                    'read_only' => true
                                                    
                                                    )
                      
                      );
        
        $builder->add ('isForConfiguration', 'hidden', array (
                                                    'data' => $this->config->getIsForConfiguration(),
                                                    'read_only' => true
                                                    
                                                    )
                      
                      );
        
        $builder->add ('configId', 'hidden', array (
                                                    'data' => $this->config->getId(),
                                                    'read_only' => true
                                                    
                                                    )
                      
                      );
        
        $builder->add ('mustBeTranslated', 'hidden', array (
                                                    'data' => $this->attributoMusBeTranslated(),
                                                    'read_only' => true
                                                    
                                                    )
                      
                      );
        
        
        $builder->add ('attributoId', 'hidden', array (
                                                    'data' => $this->getAttributo ()->getId(),
                                                    'read_only' => true
                                                    
                                                    )
                      
                      );
                      
        $builder->add ('uniqueSlug', 'hidden', array (
                                                    'data' => $this->getAttributo ()->getUniqueSlug(),
                                                    'read_only' => true
                                                    
                                                    )
                      
                      );
                      
        
        $builder = $this->getFormForTranslatedField('slug', $builder);
        
        $builder = $this->getFormForTranslatedField('name', $builder);
        
        return $builder;
    }
    
    /**
     * Si preoccupa di costruire il campo specifico per l'attributo, tenendo presente se deve essere tradotto
     *
     * @param FormBuilder $builder 
     * @param string $type 
     * @return void
     * @author Lorenzo Caldara
     */
    protected function buildFieldData(FormBuilder $builder)
    {
        $languages = $this->getLanguages();
        $basicOptions = $this->getMyBasicOptions();
        
        if ($this->attributoMusBeTranslated()) {
            $builder->add('value', 'form', $basicOptions);
            $builder =  $builder->get('value');
            foreach ($this->getLanguages() as $key => $value) {
                $this->buildSpesificFieldType ($builder, $key);
                if ($this->getConfig ()->getIsObligatory()) {
                    $builder->
                    addValidator(new CallbackValidator(function(\Symfony\Component\Form\Form  $form) use ($key, $basicOptions)
                                                       {
                                                            if (!$form[$key]->getData()) {
                                                                $form->addError(new FormError(sprintf('Il campo %s %s deve essere compilato', $basicOptions['label'], $key)));
                                                            }
                                                       }
                                               )
                                );
                 }
                
            }
        } else {
            $this->buildSpesificFieldType ($builder, 'value');
            
            if ($this->getConfig ()->getIsObligatory()) {
                    $name = $this->getAttributo ()->getName();
                    $builder->addValidator(new CallbackValidator(function(\Symfony\Component\Form\Form  $form) use ($name, $basicOptions)
                                                       {
                                                            if (!$form['value']->getData()) {
                                                                $form->addError(new FormError(sprintf('Il campo %s deve essere compilato', $basicOptions['label'])));
                                                            }
                                                       }
                                               )
                                );
            }
        }
        
    }
    
    public function getMyBasicOptions()
    {
        return array('required'=>$this->getConfig ()->getIsObligatory(), 'label' => $this->getAttributo ()->getName());
    }
    
    abstract protected function buildSpesificFieldType (FormBuilder $builder, $fieldName);
        
}
