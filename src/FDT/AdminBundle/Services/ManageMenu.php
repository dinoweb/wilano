<?php

namespace FDT\AdminBundle\Services;

class ManageMenu
{
	private $arrayMenuConfig = array ();

	public function __construct(array $arrayMenuConfig)
	{
		
		$this->arrayMenuConfig = $arrayMenuConfig;
	
	}
    
    public function getArrayMenu ()
    {
        
    	return $this->arrayMenuConfig;
    }
    
}
