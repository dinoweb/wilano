<?php

namespace FDT\MetadataBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class getLanguagesController extends Controller
{
    
    private function getLanguagesJson ()
    {
    	$languagesManager = $this->get('contenuti.languages');
    	
    	return $languagesManager->getLanguagesJson();
    	    	
    }
    
    public function indexAction($bundleName)
    {
    
        $response = new Response($this->getLanguagesJson ());
		$response->headers->set('Content-Type', 'application/json');
		
		return $response;
    }
}
