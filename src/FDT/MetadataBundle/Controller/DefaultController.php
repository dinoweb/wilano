<?php

namespace FDT\ContenutiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('FDTContenutiBundle:Default:index.html.twig', array('name' => $name));
    }
}
