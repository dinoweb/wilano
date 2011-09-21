<?php

namespace FDT\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use FDT\AdminBundle\Services\GetBundlesConfig;

class GetConfigController extends Controller
{
    
    private function getArrayBundlesConfig ()
    {
    	$bundlesConfig = $this->get('bundles_config');
    	$neededConfiguration = $this->getRequest()->get('configFor');
    	
    	$configuration = $bundlesConfig->getArrayBundlesConfig ();
    	
    	return ($configuration[$neededConfiguration]);
    	
    }
    
    public function indexAction()
    {
        $response = new Response(json_encode($this->getArrayBundlesConfig ()));
		$response->headers->set('Content-Type', 'application/json');
		
		return $response;
    }
}
