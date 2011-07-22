<?php

namespace FDT\MetadataBundle\Services;

use FDT\MetadataBundle\Exception\ValidatorErrorException;

class DocumentSaver
{
	private $documentManager;
	private $validator;

	public function __construct(\Doctrine\ODM\MongoDB\DocumentManager $documentManager, \Symfony\Component\Validator\Validator $validator)
	{
		
		$this->documentManager = $documentManager;
		$this->validator = $validator;
	
	}
    
    private function getDm ()
    {
        
    	return $this->documentManager;
    }
    
    private function getValidator ()
    {
        
    	return $this->validator;
    }
    
    private function validate ($document)
    {
    
        $errorList = $this->getValidator()->validate($document);
        
        return $errorList;
    
    }
     
    public function save ($document)
    {
        $errorList = $this->validate ($document);
        
        if ($errorList->count() > 0)
        {
          throw new ValidatorErrorException ($errorList->__toString ());
        }
        $this->getDm()->persist($document);
       	$this->getDm()->flush ();
       	$this->getDm()->clear();
       	
       	return $document;
    
    
    
    }
    
}
