<?php

namespace FDT\MetadataBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class getAttributiTipoController extends Controller
{
    
    private function getAttributiTipoJson ()
    {
    	$attributiManager = $this->get('attributi_type');
    	
    	return $attributiManager->getAttributiForSelect($returnJson = true);
    	    	
    }
    
    public function indexAction($bundleName)
    {
    
        $response = new Response($this->getAttributiTipoJson ());
		$response->headers->set('Content-Type', 'application/json');
		
		return $response;
    }
}
