<?php

namespace FDT\AdminBundle\Tests\TestCase;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\Common\DataFixtures\Loader;

class TestCase extends WebTestCase
{
    private $client = FALSE;
    
    public function setUp ()
    {
        $collectionAttributo = $this->getDm()->getDocumentCollection('FDT\MetadataBundle\Document\Attributi\DataSet');
        $collectionAttributo->drop();
        
        $collectionAttributoTranslation = $this->getDm()->getDocumentCollection('FDT\MetadataBundle\Document\Attributi\DataSetTranslation');
        $collectionAttributoTranslation->drop();
        
        $collectionAttributo = $this->getDm()->getDocumentCollection('FDT\MetadataBundle\Document\Attributi\Attributo');
        $collectionAttributo->drop();
        
        $collectionAttributoTranslation = $this->getDm()->getDocumentCollection('FDT\MetadataBundle\Document\Attributi\AttributoTranslation');
        $collectionAttributoTranslation->drop();
        
        $collectionAttributoTranslation = $this->getDm()->getDocumentCollection('FDT\MetadataBundle\Document\Attributi\Config');
        $collectionAttributoTranslation->drop();
        
        $collectionAttributoTranslation = $this->getDm()->getDocumentCollection('FDT\MetadataBundle\Document\Attributi\Config');
        $collectionAttributoTranslation->drop();
        
        $collectionAttributoTranslation = $this->getDm()->getDocumentCollection('FDT\MetadataBundle\Document\Tipologie\Prodotti');
        $collectionAttributoTranslation->drop();
        
        $collectionAttributoTranslation = $this->getDm()->getDocumentCollection('FDT\MetadataBundle\Document\Tipologie\TipologiaTranslation');
        $collectionAttributoTranslation->drop();
        
    }
           
    public function getClient()
    {
       if (!$this->client)
       {
       
        $this->client = $this->createClient(array ('test', true));
       
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
    
    
    public function loadMongoDBDataFixtures($bundleName, $arrayFixturesToLoad,$append = false)
    {
        $dm = $this->getDm();

        $loader = new Loader();
        foreach ($this->getDataFixturesPaths($bundleName, $arrayFixturesToLoad) as $path) {
            $loader->loadFromDirectory($path);
        }
        $fixtures = $loader->getFixtures();
        $purger = new \Doctrine\Common\DataFixtures\Purger\MongoDBPurger($dm);
        $executor = new \Doctrine\Common\DataFixtures\Executor\MongoDBExecutor($dm, $purger);
        $executor->execute($fixtures, $append);
    }
    
    public function getDataFixturesPaths($bundleName, $arrayFixturesToLoad)
    {
        $paths = array();
        $bundleDir = self::$kernel->getBundle($bundleName)->getPath ();
        $testFixtureDir = $bundleDir.'/Tests/Document/Fixtures';
        foreach ($arrayFixturesToLoad as $fixtureToLoad)
        {
            $fixtureDir = $testFixtureDir.'/'.$fixtureToLoad;
            if (is_dir($dir = $fixtureDir))
            {
                $paths[] = $dir;
            }
        }
        
        return $paths;
    }
    
    public function getSaver ()
    {
    
        return $this->getDic()->get('document_saver');
    
    }
    
    
    
}
