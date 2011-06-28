<?php
namespace FDT\AdminBundle\Services;

class GetBundlesConfig
{
	private $arrayBundlesConfig = array ();

	public function __construct(array $arrayBundlesConfig)
	{
		
		$this->arrayBundlesConfig = $arrayBundlesConfig;
	
	}
    
    public function getArrayBundlesConfig ()
    {
        
    	return $this->arrayBundlesConfig;
    }
    
}
