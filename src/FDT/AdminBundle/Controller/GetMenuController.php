<?php

namespace FDT\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use FDT\AdminBundle\Services\ManageMenu;

class GetMenuController extends Controller
{
    
    private function getArrayMenu ()
    {
    	$menuManager = $mailer = $this->get('manage_menu');
    	
    	return $menuManager->getArrayMenu ();
    	
    }
    
    public function indexAction()
    {
        $response = new Response(json_encode($this->getArrayMenu ()));
		$response->headers->set('Content-Type', 'application/json');
		
		return $response;
    }
}
