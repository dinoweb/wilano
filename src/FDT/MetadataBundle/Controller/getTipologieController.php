<?php

namespace FDT\MetadataBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class getTipologieController extends Controller
{
    
    private function getTipologieJson ()
    {
    	
    	    	
    }
    
    public function indexAction($bundleName)
    {
        $node = $this->get('request')->query->get('node', 'root');
        $id = uniqid();
        
        $arrayResponse = array (array(
            'id'=>$id,
            'uniqueName'=>$id,
            'uniqueSlug'=>'Unique slug',
            'leaf'=>false,
            'it_it-name'=>'Palla',
            'en_us-name'=>'Palla Inglese'
        ));
        
        $jsonResponse = json_encode($arrayResponse);
                
        $response = new Response($jsonResponse);
        $response->headers->set('Content-Type', 'application/json');
    
        return ($response);
    }
}
