<?php

namespace FDT\MetadataBundle\Services\Controller;


class ManageTipologie extends AbstractRestController
{

    protected $treeManager;
    
    public function __construct(\FDT\MetadataBundle\Services\DocumentSaver $documentSaver,
                                \FDT\doctrineExtensions\NestedSet\TreeManager $treeManager, 
                                \Symfony\Component\HttpFoundation\Request $request,
                                \Symfony\Component\HttpFoundation\Response $response,
                                \FDT\MetadataBundle\Services\Languages $languagesManager
                               )
    {
        
        parent::__construct (
            $documentSaver,
            $request,
            $response,
            $languagesManager
        );
        
        $this->treeManager = $treeManager;
    
    }
        
    protected function getFullClassName ()
    {
        
        return 'FDT\\MetadataBundle\\Document\\Tipologie\\'.$this->getTipologia();
        
    }
    
    protected function setDatiDocument ($tipologia, $data)
    {
        
        $tipologia->setUniqueName ($data['uniqueName']);
        $tipologia->setIsActive ($data['isActive']);
        $tipologia->setIsPrivate ($data['isPrivate']);
        $tipologia->setIsConfigurable ($data['isConfigurable']);
        $tipologia->setHasPeriod ($data['hasPeriod']);
        $tipologia->setIndex ($data['index']);
        
        $tipologia = $this->manageTranslationsData ($tipologia, $data);
        
        return  $tipologia; 
    }
    
    protected function saveDocument($tipologia)
    {
        
        $tipologiaOk = $this->treeManager->manageTreeMovements($tipologia, $this->getData(), $this->getRepository());
        
        $tipologia = $this->documentSaver->save($tipologiaOk);            
            
        return $tipologia;    
    }
    
    private function getTipologie ($node)
    {
        $repository = $this->getRepository();
        
        if ($node == 'idRoot'.$this->getTipologia() or $node == 'idRoot')
        {
            
            return $repository->getRoots();
        }
        else
        {
            
            $parentRecord = $repository->getByMyUniqueId ($node, 'id');
            
            $treeManager = $this->treeManager;
        
            $parentNode = $treeManager->getNode ($parentRecord);
            
            return $parentNode->getDescendants(1);
        }
            	
    	    	
    }
    
    private function hasChildren ($tipologia)
    {   
        $node = $this->treeManager->getNode ($tipologia);
        return $node->hasChildren ();
    }
    
    
    private function prepareArray($tipologia)
    {
        
        $arrayTipologia = $this->getRepository()->toArray ($tipologia);
        
        $loaded = $this->hasChildren ($tipologia)? false: true;
        
        $arrayTipologiaForTree = array(           
            'leaf'=>false,
            'loaded'=>$loaded,
            'parentId'=>null,
            
        );
        
        if ($tipologia->getLevel () > 0)
        {
            $arrayTipologiaForTree['parentId'] = $tipologia->getParent ()->getId();
        }
        
        $arrayTipologia = array_merge ($arrayTipologia, $arrayTipologiaForTree);
        
        return $arrayTipologia;
    }
    
        
    protected function executeGet()
    {
        $arrayResponse = array();
        $arrayData = array ();
        
        $node = $this->request->query->get('node', 'idRoot');
        $tipologie = $this->getTipologie($node);
        
        if ($tipologie->count() > 0)
        {
            foreach ($tipologie as $key => $value) {
                $arrayData[] = $this->prepareArray ($value);
            }
            
        }
        
        return $this->getArrayResponseGet ($arrayData);

    }
    
    protected function executeNone ()
    {
        return false;
    }
    
    
    private function setTipologia($tipologia)
    {
        $this->tipologia = (string) $tipologia;
    }
    
    private function getTipologia()
    {
        return $this->tipologia;
    }
    
    public function execute($bundleName, $tipologia)
    {
        $this->setTipologia($tipologia);
        $arrayResponse = $this->executeAction();
                
        
        $jsonResponse = json_encode($arrayResponse);
        $this->response->setContent($jsonResponse);
        $this->response->headers->set('Content-Type', 'application/json');
    
        return ($this->response);
    }
}
