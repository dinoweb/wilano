<?php

namespace FDT\MetadataBundle\Services;

use FDT\MetadataBundle\Document\Attributi;
use FDT\MetadataBundle\Exception\ValidatorErrorException;

class AttributoSaver
{
	private $documentManager;
	private $validator;

	public function __construct(\Doctrine\ODM\MongoDB\DocumentManager $documentManager, \Symfony\Component\Validator\Validator $validator)
	{
		
		$this->documentManager = $documentManager;
		$this->validator = $validator;
	
	}
    
    private function getDocumentManager ()
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
        $this->getDocumentManager()->persist($document);
       	$this->getDocumentManager()->flush ();
       	
       	return $document;
    
    
    
    }
    
}
