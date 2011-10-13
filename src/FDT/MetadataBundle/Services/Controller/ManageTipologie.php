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
    
    
    private function saveTipologia($tipologia)
    {
        
        $tipologiaOk = $this->treeManager->manageTreeMovements($tipologia, $this->getData(), $this->getRepository());
        
        $tipologia = $this->documentSaver->save($tipologiaOk);            
            
        return $tipologia;    
    }
    
    private function getTipologie ($node)
    {
        $repository = $this->documentManager->getRepository('FDT\\MetadataBundle\\Document\\Tipologie\\'.$this->getTipologia());
        
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
    
    private function setDataTipologia ($tipologia, $data)
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
    
    public function getTranslationRepository ()
    {
        return $this->documentManager->getRepository('FDT\MetadataBundle\Document\Tipologie\TipologiaTranslation');
    }
    
    protected function getFullClassName ()
    {
        
        return 'FDT\\MetadataBundle\\Document\\Tipologie\\'.$this->getTipologia();
        
    }
    
    
    private function prepareArray($tipologia)
    {
        
        $arrayTipologia = $this->getRepository()->toArray ($tipologia);
        
        $arrayTipologiaForTree = array(           
            'leaf'=>false,
            'parentId'=>null,
            
        );
        
        if ($tipologia->getLevel () > 0)
        {
            $arrayTipologiaForTree['parentId'] = $tipologia->getParent ()->getId();
        }
        
        $arrayTipologia = array_merge ($arrayTipologia, $arrayTipologiaForTree);
        
        return $arrayTipologia;
    }
    
    protected function executeAdd()
    {
        $requestData = $this->getData();
        $tipologia = $this->getTipologia();
        $className = 'FDT\\MetadataBundle\\Document\\Tipologie\\'.$tipologia;
        $tipologia = new $className;
        $tipologia = $this->setDataTipologia ($tipologia, $requestData);
        $tipologiaOk = $this->saveTipologia($tipologia);
        $response = array ('success'=>true, 'message'=>'Tipologie aggiornate con successo');
        return $response;        
        
    }
    
    protected function executeUpdate()
    {
        $repository = $this->documentManager->getRepository('FDT\\MetadataBundle\\Document\\Tipologie\\'.$this->getTipologia());
        $requestData = $this->getData();
        $tipologia = $repository->getByMyUniqueId ($requestData['id'], 'id');
        $tipologia = $this->setDataTipologia ($tipologia, $requestData);
        $tipologiaOk = $this->saveTipologia($tipologia);
        
        //$tipologiaOk = $this->manageTree($tipologia, $requestData);
        $response = array ('success'=>true, 'message'=>'Tipologie aggiornate con successo');
        return $response;
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
        
        $arrayResponse['success'] = true;
        $arrayResponse['total'] = count ($arrayData);
        $arrayResponse['results'] = $arrayData;
        
        
        return $arrayResponse;
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
    
    public function indexAction($bundleName, $tipologia)
    {
        $this->setTipologia($tipologia);
        $arrayResponse = $this->executeAction();
                
        
        $jsonResponse = json_encode($arrayResponse);
        $this->response->setContent($jsonResponse);
        $this->response->headers->set('Content-Type', 'application/json');
    
        return ($this->response);
    }
}
