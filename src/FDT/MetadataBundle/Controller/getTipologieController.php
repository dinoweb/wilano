<?php

namespace FDT\MetadataBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class getTipologieController extends Controller
{
    private $tipologia;
    
    private function getTipologie ($node)
    {
        $repository = $this->get('doctrine.odm.mongodb.document_manager')->getRepository('FDT\\MetadataBundle\\Document\\Tipologie\\'.$this->getTipologia());
        
        if ($node == 'idRoot'.$this->getTipologia() or $node == 'idRoot')
        {
            
            return $repository->getRoots();
        }
        else
        {
            
            $parentRecord = $repository->getByMyUniqueId ($node, 'id');
            
            $treeManager = $this->get('tree_manager');
        
            $parentNode = $treeManager->getNode ($parentRecord);
            
            return $parentNode->getDescendants(1);
        }
            	
    	    	
    }
    
    private function setTipologia($tipologia)
    {
        $this->tipologia = (string) $tipologia;
    }
    
    private function getTipologia()
    {
        return $this->tipologia;
    }
    
    private function prepareArray($tipologia)
    {
        
        $arrayTipologia = array(
            'id'=>$tipologia->getId(),
            'uniqueName'=>$tipologia->getUniqueName(),
            'uniqueSlug'=>$tipologia->getUniqueSlug(),
            'leaf'=>false
        );
        
        $repository = $this->get('doctrine.odm.mongodb.document_manager')->getRepository('FDT\MetadataBundle\Document\Tipologie\TipologiaTranslation');
        $translations = $repository->findTranslations($tipologia);
        
        if (count ($translations) > 0)
        {   
        //print_r($translations);         
            foreach ($translations as $key=>$arrayValue)
            {
                foreach ($arrayValue as $name=>$value)
                {
                    $stringLangName = 'Translation-'.$key.'-'.$name;
                    $arrayTipologia[$stringLangName] = $value;
                }
            }
        }
        
        return $arrayTipologia;
    }
    
    public function indexAction($bundleName, $tipologia)
    {
        $this->setTipologia($tipologia);
        
        $arrayResponse = array();
        
        $node = $this->get('request')->query->get('node', 'idRoot');
        $tipologie = $this->getTipologie($node);
        
        if ($tipologie->count() > 0)
        {
            foreach ($tipologie as $key => $value) {
                $arrayResponse[] = $this->prepareArray ($value);
            }
            
        }
        
        
    
        
        $jsonResponse = json_encode($arrayResponse);
                
        $response = new Response($jsonResponse);
        $response->headers->set('Content-Type', 'application/json');
    
        return ($response);
    }
}
