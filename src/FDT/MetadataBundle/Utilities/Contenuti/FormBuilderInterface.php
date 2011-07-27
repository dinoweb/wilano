<?php
namespace FDT\MetadataBundle\Utilities\Contenuti;
use FDT\MetadataBundle\Document\Tipologie as DocumentTipologia;
use FDT\MetadataBundle\Exception\FormTypeDoNotExistException;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormBuilder;

abstract class FormBuilderInterface
{
    
    private $formBuilder; 
    
    /**
     * Array contenente le lingue da gestire
     *
     * @var array
     */
    private $languages = array();
    
    /**
     * Array contenente le classi dei ingoli form
     *
     * @var array
     */
    private $formClasses = array();
    
    /**
     * Constractor che setta le lingue da gestire
     *
     * @param array $languages 
     * @author Lorenzo Caldara
     */
    function __construct(array $languages, array $formClasses, FormFactoryInterface $formFactory)
    {
        $this->languages = $languages;
        $this->formClasses = $formClasses;
        $this->createBuilder($formFactory);
    }
    
    private function createBuilder (FormFactoryInterface $formFactory)
    {
        $this->formBuilder = $formFactory->createBuilder('form');
    }
    
    protected function getFormBuilder ()
    {
        
        return $this->formBuilder;
        
    }
    
    /**
     * Return an array of languages
     *
     * @return array Languages
     * @author Lorenzo Caldara
     */
    protected function getLanguages()
    {
        return $this->languages;
    }
    
    
    /**
     * Se esiste mi ritorna un instanza della classe form se no una eccezione FormTypeDoNotExistException
     *
     * @param string $instanceName il nome del form che voglio venga instanziato
     * @author Lorenzo Caldara
     */
    protected function getFormTypeInstance ($instanceName, $configObject = FALSE)
    {
        if (isset($this->formClasses[$instanceName])) {
            $className = $this->formClasses[$instanceName].'Type';
            $classWithNamespace = 'FDT\\MetadataBundle\\Form\\Type\\'.$className;
            return (new $classWithNamespace($configObject));
        }
        
        throw new FormTypeDoNotExistException(sprintf('Il form di tipo %s non esiste', $instanceName));        
    }
    
    public function getForm ()
    {
        
        return $this->getFormBuilder ()->getForm();
        
    }
    
    /**
     * Setta la Tipologia del contenuto per cui dobbiamo costruire il form
     *
     * @param BaseTipologia $tipologia 
     * @return Form
     * @author Lorenzo Caldara
     */
    abstract public function setTipologia(DocumentTipologia\BaseTipologia $tipologia);
}