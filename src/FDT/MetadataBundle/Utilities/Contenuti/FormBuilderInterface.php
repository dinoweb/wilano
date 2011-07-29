<?php
namespace FDT\MetadataBundle\Utilities\Contenuti;
use FDT\MetadataBundle\Document\Tipologie as DocumentTipologia;
use FDT\MetadataBundle\Exception\FormTypeDoNotExistException;
use FDT\MetadataBundle\Services\AttributiTypeManager;
use FDT\doctrineExtensions\NestedSet\TreeManager;
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
     * La classe per la gestione dei tipi di attributi
     *
     * @var FDT\MetadataBundle\Sevices\AttributiTypeManager
     */
    private $attributiTypeManager;
    
    /**
     * La classe per la gestione dei tree
     *
     * @var FDT\doctrineExtensions\NestedSet\TreeManager
     */
    private $treeManager;
    
    /**
     * Constractor che setta le lingue da gestire
     *
     * @param array $languages 
     * @author Lorenzo Caldara
     */
    function __construct(FormFactoryInterface $formFactory, AttributiTypeManager $attributiTypeManager, TreeManager $treeManager ,array $formClasses, array $languages )
    {
        $this->languages = $languages;
        $this->formClasses = $formClasses;
        $this->createBuilder($formFactory);
        $this->setAttributiTypeManager ($attributiTypeManager);
        $this->treeManager = $treeManager;
    }
    
    /**
     * @param FormFactoryInterface $formFactory 
     * @return void
     * @author Lorenzo Caldara
     */
    private function createBuilder(FormFactoryInterface $formFactory)
    {
        $this->formBuilder = $formFactory->createBuilder('form');
    }
    
    /**
     * @return Symfony\Component\Form\FormBuilder
     *
     * @author Lorenzo Caldara
     */
    protected function getFormBuilder ()
    {
        return $this->formBuilder;
    }
    
    /**
     * @param AttributiTypeManager $attributiTypeManager 
     * @return void
     * @author Lorenzo Caldara
     */
    private function setAttributiTypeManager(AttributiTypeManager $attributiTypeManager)
    {
        $this->attributiTypeManager = $attributiTypeManager;
    }
    
    /**
     * @return AttributiTypeManager
     *
     * @author Lorenzo Caldara
     */
    protected function getAttributiTypeManager ()
    {
        
        return $this->attributiTypeManager;
        
    }
    
    /**
     * @return TreeManager
     *
     * @author Lorenzo Caldara
     */
    protected function getTreeManager ()
    {
        
        return $this->treeManager;
        
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
    protected function getFormTypeInstance ($instanceName, $service = FALSE)
    {   
        if (isset($this->formClasses[$instanceName])) {
            $className = $this->formClasses[$instanceName];
            if (class_exists($className)) {
                if (get_parent_class($className) == 'FDT\MetadataBundle\Form\Type\AbstractContenutoType') {
                    return (new $className($this->getTipologia(), $service, $this->getLanguages()));
                }
                throw new FormTypeDoNotExistException(sprintf('La classe di tipo %s deve essere figlia di FDT\MetadataBundle\Form\Type\AbstractContenutoType', $className));
            }
            throw new FormTypeDoNotExistException(sprintf('La classe di tipo %s non esiste', $className));
        }
        
        throw new FormTypeDoNotExistException(sprintf('La chiave %s non esiste nella configurazione', $instanceName));        
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