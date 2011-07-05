<?php

namespace FDT\AdminBundle\Tests\TestCase;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TestCase extends WebTestCase
{
    private $client = FALSE; 
    
    public function getClient()
    {
       if (!$this->client)
       {
       
        $this->client = static::createClient();
       
       }
       return $this->client;
    }
    
    public function getDic ()
    {
    
        return $this->getClient ()->getContainer ();
    
    }

    /**
     * @return Doctrine\ORM\EntityManager
     */
    public function getEm()
    {

        return $this->getDic()->get('doctrine.orm.entity_manager');
    }

    /**
     * @return Doctrine\ODM\MongoDB\DocumentManager
     */
    public function getDm()
    {

        return $this->getDic()->get('doctrine.odm.mongodb.document_manager');
    }
    
    
}
