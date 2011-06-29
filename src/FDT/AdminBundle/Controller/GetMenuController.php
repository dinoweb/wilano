<?php

namespace FDT\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use FDT\AdminBundle\Services\ManageMenu;

class GetMenuController extends Controller
{
    
    private function getArrayMenu ($bundleName)
    {
    	$menuManager = $this->get('manage_menu');
    	
    	$arrayMenu = $menuManager->getArrayMenu ();
    	
    	if (isset($arrayMenu[$bundleName]))
    	{
    	
    	   return $arrayMenu[$bundleName];
    	
    	}
    	    	
    }
    
    public function indexAction($bundleName)
    {
    
        $response = new Response(json_encode($this->getArrayMenu ($bundleName)));
		$response->headers->set('Content-Type', 'application/json');
		
		return $response;
    }
}
