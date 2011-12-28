<?php

namespace FDT\MetadataBundle\Services\Controller;
use Doctrine\Common\Annotations\AnnotationReader;

/**
 * 
 */
abstract class AbstractRestController
{
    protected $documentSaver;
    protected $documentManager;
    protected $request;
    protected $response;
    protected $languages;
    protected $requestData;
    
    
    public function __construct(\FDT\MetadataBundle\Services\DocumentSaver $documentSaver,
                                \Symfony\Component\HttpFoundation\Request $request,
                                \Symfony\Component\HttpFoundation\Response $response,
                                \FDT\MetadataBundle\Services\Languages $languagesManager
                               )
    {
        $this->documentSaver = $documentSaver;
        $this->documentManager = $documentSaver->getDm();
        $this->request = $request;
        $this->response = $response;
        $this->languages = $languagesManager;
        
        $this->setRequestData ();
    
    }
    
    abstract protected function getFullClassName();
    abstract protected function setDatiDocument($document, $data);
    
    /**
     *
     * @return type Repository
     */
    protected function getRelatedRepository ()
    {
        return $this->documentManager->getRepository($this->getFullRelatedClassName())->setLanguages($this->languages);
    }
    
    
    /**
     *
     * @return type Repository
     */
    protected function getRepository ()
    {
        return $this->documentManager->getRepository($this->getFullClassName())->setLanguages($this->languages);
    }
    
    
    /**
     *
     * @return type array
     */
    protected function getRelatedClassRequestData ($keyToBeReturned = FALSE)
    {
        $arrayRelated = array();
        $arrayRelated['ownerType'] =  preg_replace('/__/', "\\\\", $this->request->get('ownerType'));
        $arrayRelated['ownerId'] = $this->request->get('ownerId');
        $arrayRelated['relatedType'] =  preg_replace('/__/', "\\\\", $this->request->get('relatedType'));
        $arrayRelated['relationType'] =  $this->request->get('relationType');
        $arrayRelated['getRelationFunction'] = $this->request->get('getRelationFunction');
        $arrayRelated['setRelationFunction'] = $this->request->get('setRelationFunction');
        
        
        if ($keyToBeReturned and array_key_exists($keyToBeReturned, $arrayRelated))
        {
            return $arrayRelated[$keyToBeReturned];
        }
        
        return $arrayRelated;
    }
    
    /**
     *
     * @return type array
     */
    protected function getLimitData ()
    {
        $arrayLimit = array();
        $arrayLimit['limit'] = $this->request->get('limit', 20);
        $arrayLimit['skip'] = $this->request->get('start', 0);
        
        return $arrayLimit;
    }
    
    /**
     * inizializza l'array con i dati passati fal form
     * @return void
     */
    protected function setRequestData ()
    {
        $requestData = json_decode($this->request->getContent (), true);
        if (!is_null($requestData))
        {
            $this->requestData = $this->languages->normalizeTranslationsDataFromForm ($requestData);
        }
        
    }
    
    private function getReader ()
    {
    
        $reader = new AnnotationReader();        
        return $reader;
    
    
    }
    
    
     /**
     * 
     */
    public function getTranslationRepository ($document)
    {
        $documentManager = $this->documentManager;
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
    
    /**
     *
     * @param type $document
     * @param type array $data
     * @return type Document
     */
    protected function manageTranslationsData ($document, $data)
    {
        if (!isset($data['Translations']))
        {
            return $document;
        }
        
        $repository = $this->getTranslationRepository(get_class($document));
        $useLocale = $this->languages->getUserLocale ();
        
        foreach ($data['Translations'] as $langKey=>$arrayFields)
        {   
            
            foreach ($arrayFields as $key=>$value)
            {
                if ($useLocale == $langKey)
                {
                    $setFunction = 'set'.ucfirst($key);
                    $document->$setFunction($value);
                
                }
                else
                {
                    $repository->translate($document, $key, $langKey, $value);
                }
                
                
                
                
            }
            
        }
        return $document;
        
        
        
    }
    
    protected function getData ()
    {
        return $this->requestData;    	    	
    }
    
    /**
     *
     * @param array $arrayData
     * @return array Response
     */
    protected function getArrayResponseGet (array $arrayData)
    {
        $arrayResponse['success'] = true;
        $arrayResponse['total'] = count ($arrayData);
        $arrayResponse['results'] = $arrayData;
        
        return $arrayResponse;
    }
    
    protected function executeAdd()
    {
        $requestData = $this->getData();
        $className = $this->getFullClassName();
        $document = new $className;
        $document = $this->setDatiDocument ($document, $requestData);
        $documentOk = $this->saveDocument($document);
        $response = array ('success'=>true, 'message'=>'Record aggiunto con successo');
        return $response;   
    }
    
    protected function executeUpdate()
    {
        $repository = $this->getRepository();
        $requestData = $this->getData();
        $document = $repository->getByMyUniqueId ($requestData['id'], 'id');
        $document = $this->setDatiDocument ($document, $requestData);
        $documentOk = $this->saveDocument($document);
        
        //$tipologiaOk = $this->manageTree($tipologia, $requestData);
        $response = array ('success'=>true, 'message'=>'Record aggiornato con successo');
        return $response;
    }
    
    protected function executeGet()
    {
        $arrayResponse = $this->getRepository()->generateCursor ($this->getLimitData ())->returnAsArray();
        return $arrayResponse;
        
    }
    
    protected function executeNone ()
    {
        return false;
    }
    
    protected function saveDocument($document)
    {
        $document = $this->documentSaver->save($document);            
            
        return $document;    
    }
    
    /**
     *
     * @return type array
     */
    protected function executeAction ()
    {
        $method = $this->request->getMethod();
        
        switch ($method) {
            case 'POST':
                $result = $this->executeAdd ();
            break;
            
            case 'PUT':
                $result = $this->executeUpdate ();
            break;
            
            case 'GET':
                $result = $this->executeGet ();
            break;
            
            default:
                $result = $this->executeNone ();
            break;
        }
        
        return $result;
    }
    
    /**
     *
     * @param type string $bundleName
     * @param type string $tipologia
     * @return type Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($bundleName = NULL, $tipologia = NULL)
    {
        $arrayResponse = $this->executeAction();
                
        
        $jsonResponse = json_encode($arrayResponse);
        $this->response->setContent($jsonResponse);
        $this->response->headers->set('Content-Type', 'application/json');
    
        return ($this->response);
    }
    
    
}
