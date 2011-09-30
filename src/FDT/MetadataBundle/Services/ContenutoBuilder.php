<?php
namespace FDT\MetadataBundle\Services;
use FDT\MetadataBundle\Services\AttributiTypeManager;
use FDT\MetadataBundle\Services\DocumentSaver;
use FDT\doctrineExtensions\NestedSet\TreeManager;
use Doctrine\ODM\MongoDB\DocumentManager; 


/**
* Classe preposta alla creazione di un contenuto sulla base dei dati provenienti da un form
*/
class ContenutoBuilder
{
    /**
     * DocumentManager $documentManager
     *
     * @var DocumentManager
     */
    private $dm;
    
    /**
     * AttributiTypeManager $attributiTypeManager
     *
     * @var AttributiTypeManager
     */
    private $attributiTypeManager;
    
     /**
     * TreeManager $treeManager
     *
     * @var TreeManager
     */
    private $treeManager;
    
     /**
     * DocumentSaver $documentSaver
     *
     * @var DocumentSaver
     */
    private $documentSaver;
    
    /**
     * array $languages
     *
     * @var array
     */
    private $languages;
    
    /**
     * @var FDT\MetadataBundle\Document\Tipologie\BaseTipologia
     */
    private $tipologia;
    
    /**
     * @var FDT\MetadataBundle\Document\Contenuti\BaseContenuto
     */
    private $contenutoDocument = false;
    
    /**
     * @param DocumentManager $documentManager 
     * @param AttributiTypeManager $attributiTypeManager 
     * @param TreeManager $treeManager 
     * @param array $languages 
     * @author Lorenzo Caldara
     */
    public function __construct(DocumentManager $documentManager, AttributiTypeManager $attributiTypeManager, TreeManager $treeManager, DocumentSaver $documentSaver, array $languages)
    {
        $this->documentManager = $documentManager;
        $this->attributiTypeManager = $attributiTypeManager;
        $this->treeManager = $treeManager;
        $this->documentSaver = $documentSaver;
        $this->languages = $languages;
       
    }
    
    private function getDm ()
    {
        return $this->documentManager;
    }
    
    private function getDocumentSaver ()
    {
        return $this->documentSaver;
    }
    
    private function getAttributiTypeManager()
    {
        return $this->attributiTypeManager;
    }
    
    private function setTipologia(array $contenutoData)
    {
        $this->tipologia = $this->getDm()->getRepository($contenutoData['tipologiaClass'])->findOneById($contenutoData['tipologiaId']);
    }
    
    private function getTipologia()
    {
        return $this->tipologia;
    }
    
    private function initContenutoDocument()
    {
        if (!$this->contenutoDocument) {
            $contenutoType = $this->getTipologia()->getType();
            $contenutoType = 'FDT\\MetadataBundle\\Document\\Contenuti\\'.$contenutoType;
            $this->contenutoDocument = new $contenutoType;
        }
    }
    
    private function getContenutoDocument()
    {
        return $this->contenutoDocument;
    }
    
    private function buildBaseContent (array $contenutoData)
    {
        $this->getContenutoDocument()->setNames ($contenutoData['name']);
        $this->getContenutoDocument()->setTipologia ($this->getTipologia());
    }
    
    private function buildAttributoValue (array $attributoData)
    {
        $valueDocumentClass = $this->getAttributiTypeManager()->getValueDocumentClass($attributoData['attributoTipo']);
        
        $attributoValueDocument = new $valueDocumentClass();
        $attributoValueDocument->build ($attributoData);
        
        //$attributoValueDocument = $this->getDocumentSaver()->save($attributoValueDocument, FALSE);
                
        return $attributoValueDocument;
        
    }
    
    private function buildAttributiValue(array $attributiData)
    {
        foreach ($attributiData as $attributo) {
            $attributoValueDocument = $this->buildAttributoValue($attributo);
            $this->getContenutoDocument()->addAttributoValue($attributoValueDocument);
        }
    }
    
    /**
     *
     * @param array $contenutoData ricevuto dall'invio di un form
     * @return FDT\MetadataBundle\Document\Contenuti\BaseContenuto
     * @author Lorenzo Caldara
     */
    public function build(array $contenutoData)
    {
        //print_r($contenutoData);
        $this->setTipologia($contenutoData['contenuto']);
        $this->initContenutoDocument();
        $this->buildBaseContent($contenutoData['contenuto']);
        $this->buildAttributiValue($contenutoData['attributi']);
        
        $contenuto = $this->getDocumentSaver()->save($this->getContenutoDocument());
        
    }
    
}


