<?php
namespace FDT\MetadataBundle\Document;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Doctrine\Common\Annotations\AnnotationReader;
use FDT\MetadataBundle\Exception\ValidatorErrorException;
use Metadata\ClassMetadata;




class BaseRepository extends DocumentRepository
{
    private $cursor = false;
    private $languagesManager = false;
    private $translationRepository = false;
    
    protected function setCursor ($cursor)
    {
        $this->cursor = $cursor;
    }
    
    public function getCursor ()
    {
        return $this->cursor;
    }
    
    public function setLanguages (\FDT\MetadataBundle\Services\Languages $languagesManager)
    {
        $this->languagesManager = $languagesManager;
        return $this;
    }
    
    protected function getLanguages()
    {
        return $this->languagesManager;
    }
    
    /**
     * 
     */
    public function getTranslationRepository ($document)
    {
        $documentManager = $this->getDocumentManager();
        $classMetadata = $documentManager->getClassMetadata($document);                
        $reflClass = $classMetadata->getReflectionClass();
        
        $translationRepositoryAnnotation = $this->getReader()->getClassAnnotation ($reflClass, '\Gedmo\Mapping\Annotation\TranslationEntity');
        if ($translationRepositoryAnnotation)
        {
            return $documentManager->getRepository($translationRepositoryAnnotation->class);
        }
        
        $parentClass = $reflClass->getParentClass();
        
        if ($parentClass)
        {
            return $this->getTranslationRepository ($parentClass->getName());
        }
        
        return false;
        
    }
    
    
    
    public function getByMyUniqueId($uniqueSlug, $field = 'uniqueSlug')
    {
        $cursor = $this->createQueryBuilder()
                     ->field($field)->equals($uniqueSlug)
                     ->getQuery()
                     ->execute();
        
        if ($cursor->count() == 1)
        {
        
            return $cursor->getSingleResult();
        
        }
        
        if ($cursor->count() > 1)
        {
        
            throw new DocumentNotUniqueException (sprintf('Il documento avente il campo %s uguale a %s non è unico', $field, $uniqueSlug));
        
        }
            
        return FALSE;
    }
    
    private function getReader ()
    {
    
        $reader = new AnnotationReader();        
        return $reader;
    
    
    }
    
    public function hasReference ($property, $tipo)
    {
        return $this->getReader()->getPropertyAnnotation ($property, '\Doctrine\ODM\MongoDB\Mapping\Annotations\Reference'.$tipo);
    }
    
    private function manageReferenceOne ($document, $getterMethodName)
    {
    
        $refernceData = $document->$getterMethodName();
        $referencesArray = array ();
        if ($refernceData)
        {
            $referencesArray = $this->toArray ($refernceData);
        }
        
        return $referencesArray;
    
    
    }
    
    
    private function manageReferenceMany ($document, $getterMethodName)
    {
    
        $refernceDataCollection = $document->$getterMethodName();
        $referencesArray = array ();
        if ($refernceDataCollection->count () > 0)
        {   
            foreach ($refernceDataCollection as $refernceData)
            {
            
                $referencesArray[] = $this->toArray ($refernceData);
            
            }
            
            
        }
        
        return $referencesArray;
    
    
    }
    
    private function getArrayTranslations ($document)
    {
        $arrayTranslations = array ();
        $translationRepository  = $this->getTranslationRepository(get_class($document));
        if ($this->getLanguages() and $translationRepository)
        {
           $arrayTranslations = $this->getLanguages()->prepareTranslationDataForForms($document, $translationRepository); 
        }
        return $arrayTranslations;
    }
    
    
    public function toArray ($document, $deep = false)
    {
        $classMetadata = $this->getClassMetadata();                
        
        $arrayDocument = array();
        
        foreach ($classMetadata->getReflectionProperties() as $property)
        {
            
            $referenceOne = $this->hasReference ($property, 'One');
            $referenceMany = $this->hasReference ($property, 'Many');
                        
            $name = $property->getName();
            $getterMethodName = 'get'.ucfirst($name);

            if (method_exists($document, $getterMethodName))
            {
                
                if ($referenceOne and $deep)
                {
                    $valueData = $this->manageReferenceOne ($document, $getterMethodName);
                }
                else if ($referenceMany and $deep)
                {
                    $valueData = $this->manageReferenceMany ($document, $getterMethodName);
                }
                else
                {
                    $valueData = $document->$getterMethodName();
                }
                
              $arrayDocument[$name] =  $valueData;
            }
            
        }
                
        $arrayTranslations = $this->getArrayTranslations ($document);
        $valueData = array_merge ($arrayDocument, $arrayTranslations);
        
        return  array_merge($arrayDocument, $arrayTranslations);
    
    }
    
    public function returnAsArray ($deep = false)
    {
        $arrayResult = array ();
        
        $cursor = $this->getCursor ();
        $arrayResult['success'] = true;
        $arrayResult['total'] = $cursor->count ();
        $arrayResult['results'] = array();
        if ($cursor->count () > 0)
        {
            foreach ($cursor as $document)
            {
             $arrayResult['results'][] = $this->toArray($document, $deep);
            }
        }
        
        return $arrayResult;
    
    }
    
 }