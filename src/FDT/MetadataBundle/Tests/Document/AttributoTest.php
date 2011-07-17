<?php

namespace FDT\MetadataBundle\Tests\Document;

use FDT\MetadataBundle\Document\Attributi\Attributo;
use FDT\AdminBundle\Tests\TestCase\TestCase;
use FDT\MetadataBundle\Exception\ValidatorErrorException;


class AttributoTest extends TestCase
{
    public function setUp ()
    {
        
        $collectionAttributo = $this->getDm()->getDocumentCollection('FDT\MetadataBundle\Document\Attributi\Attributo');
        $collectionAttributo->drop();
        
        $collectionAttributoTranslation = $this->getDm()->getDocumentCollection('FDT\MetadataBundle\Document\Attributi\AttributoTranslation');
        $collectionAttributoTranslation->drop();
        
       
    
    
    }

    public function testAddAttributo ()
    {
    	
    	$attributo = new Attributo ();
       	$attributo->setName ('Peso palla');
       	$attributo->setUniqueName ('Peso visibile');
       	$attributo->setTipo ('weigth');
       	
       	
       	$this->getSaver()->save($attributo);
       	
       	$attributoResult = $this->getDm()->createQueryBuilder('FDT\MetadataBundle\Document\Attributi\Attributo')
                           ->field('uniqueSlug')->equals('peso-visibile')
                           ->getQuery()
                           ->getSingleResult();
       	       	
       	$this->assertTrue ($attributoResult->isActive());
       	
       	$attributoResult->setIsActive(false);
       	$this->getSaver()->save($attributoResult);
       	$this->getDm()->clear();
       	
       	$attributoResult2 = $this->getDm()->createQueryBuilder('FDT\MetadataBundle\Document\Attributi\Attributo')
                           ->field('uniqueSlug')->equals('peso-visibile')
                           ->getQuery()
                           ->getSingleResult();
       	       	
       	$this->assertFalse ($attributoResult2->isActive());
       	
       	$repository = $this->getDm()->getRepository('FDT\MetadataBundle\Document\Attributi\AttributoTranslation');
        $translations = $repository->findTranslations($attributoResult2);
                
        $this->assertEquals('peso-visibile', $attributoResult2->getUniqueSlug());
        $this->assertArrayHasKey('en_us', $translations);
        $this->assertEquals('peso-palla', $translations['en_us']['slug']);
        
        $attributo2 = new Attributo ();
       	$attributo2->setName ('Peso palla');
       	$attributo2->setUniqueName ('Peso visibile');
       	$attributo2->setTipo ('weigth');
       	$attributo2->setDescrizione ('descrizione');
       	
       	$this->getSaver()->save($attributo2);
       	$this->getDm()->clear();
       	
       	$this->assertEquals('peso-visibile-1', $attributo2->getUniqueSlug());
       	
       	    
    
    }
    
    public function testAddAttributoTranslation ()
    {
    	
    	$attributo = new Attributo ();
       	$attributo->setName ('Peso palla');
       	$attributo->setUniqueName ('Peso visibile');
       	$attributo->setTipo ('weigth');
       	$attributo->setDescrizione ('descrizione');
       	
       	$this->getSaver()->save($attributo);

       	$this->getDm()->clear();
       	
       	
       	$repository = $this->getDm()->getRepository('FDT\MetadataBundle\Document\Attributi\AttributoTranslation');
        $translations = $repository->findTranslations($attributo);
        
        $this->assertEquals('Peso visibile', $attributo->getUniqueName());
        $this->assertEquals('peso-visibile', $attributo->getUniqueSlug());
        $this->assertEquals('weigth', $attributo->getTipo());
        $this->assertArrayHasKey('en_us', $translations);
        $this->assertEquals('peso-palla', $translations['en_us']['slug']);
        $this->assertEquals('descrizione', $translations['en_us']['descrizione']);
        $this->assertEquals('Peso palla', $translations['en_us']['name']);
                    
    
    }
    
    public function testValidation ()
    {
    	
    	$attributo = new Attributo ();
       	$attributo->setName ('Peso palla');
       	$attributo->setUniqueName ('Peso visibile');
       	$attributo->setDescrizione ('descrizione');
       	       	
       	try 
       	{
            $this->getSaver()->save($attributo);
        }
        catch (ValidatorErrorException $expected)
        {
            return;
        }
 
        $this->fail('An expected ValidatorErrorException has not been raised.');
       	
       	
       	
                    
    
    }
    
    private function getSaver ()
    {
    
        return $this->getDic()->get('attributo_saver');
    
    }
    

        
    

}