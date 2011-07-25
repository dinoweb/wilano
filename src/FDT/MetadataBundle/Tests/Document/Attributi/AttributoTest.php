<?php

namespace FDT\MetadataBundle\Tests\Document\Attributi;

use FDT\MetadataBundle\Document\Attributi\Attributo;
use FDT\AdminBundle\Tests\TestCase\TestCase;
use FDT\MetadataBundle\Exception\ValidatorErrorException;


class AttributoTest extends TestCase
{

    public function testAddAttributo ()
    {
    	
    	$attributo = new Attributo ();
       	$attributo->setName ('Peso palla');
       	$attributo->setDescrizione ('Descrizione');
       	$attributo->setUniqueName ('Peso visibile');
       	$attributo->setTipo ('weight');
       	
       	
       	$this->getSaver()->save($attributo);
       	
       	$attributoResult = $this->getDm()->createQueryBuilder('FDT\MetadataBundle\Document\Attributi\Attributo')
                           ->field('uniqueSlug')->equals('peso-visibile')
                           ->getQuery()
                           ->getSingleResult();
       	       	
       	$this->assertTrue ($attributoResult->isActive());
       	
       	$attributoResult->setIsActive(false);
       	$attributo->setName ('Peso');
       	$this->getSaver()->save($attributoResult);
       	
       	
       	$attributoResult2 = $this->getDm()->createQueryBuilder('FDT\MetadataBundle\Document\Attributi\Attributo')
                           ->field('uniqueSlug')->equals('peso-visibile')
                           ->getQuery()
                           ->getSingleResult();
       	       	
       	$this->assertFalse ($attributoResult2->isActive());
       	
       	$repository = $this->getDm()->getRepository('FDT\MetadataBundle\Document\Attributi\AttributoTranslation');
        $translations = $repository->findTranslations($attributoResult2);
                
        $this->assertEquals('peso-visibile', $attributoResult2->getUniqueSlug());
        $this->assertArrayHasKey('en_us', $translations);
        $this->assertEquals('peso', $translations['en_us']['slug']);
        
        $attributo2 = new Attributo ();
       	$attributo2->setName ('Peso palla');
       	$attributo2->setDescrizione ('Descrizione');
       	$attributo2->setUniqueName ('Peso visibile');
       	$attributo2->setTipo ('weight');
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
       	$attributo->setTipo ('weight');
       	$attributo->setDescrizione ('descrizione');
       	
       	$this->getSaver()->save($attributo);

       	$this->getDm()->clear();
       	
       	
       	$repository = $this->getDm()->getRepository('FDT\MetadataBundle\Document\Attributi\AttributoTranslation');
        $translations = $repository->findTranslations($attributo);
        
        $this->assertEquals('Peso visibile', $attributo->getUniqueName());
        $this->assertEquals('peso-visibile', $attributo->getUniqueSlug());
        $this->assertEquals('weight', $attributo->getTipo());
        $this->assertArrayHasKey('en_us', $translations);
        $this->assertEquals('peso-palla', $translations['en_us']['slug']);
        $this->assertEquals('descrizione', $translations['en_us']['descrizione']);
        $this->assertEquals('Peso palla', $translations['en_us']['name']);
                    
    
    }
    
    public function testValidationRequired ()
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
       	
       	
       	$attributo = new Attributo ();
       	$attributo->setName ('Peso palla');
       	$attributo->setUniqueName ('Peso visibile');
       	$attributo->setDescrizione ('descrizione');
       	$attributo->setTipo ('text');
       	
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
    
    public function testValidationChoise ()
    {
    	       	
       	$attributo = new Attributo ();
       	$attributo->setName ('Peso palla');
       	$attributo->setUniqueName ('Peso visibile');
       	$attributo->setDescrizione ('descrizione');
       	$attributo->setTipo ('palla');
       	
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
    
    public function testUpdatableSlug()
    {
        $attributo = new Attributo ();
       	$attributo->setName ('Peso palla');
       	$attributo->setDescrizione ('descrizione');
       	$attributo->setUniqueName ('Peso visibile');
       	$attributo->setTipo ('text');
       	
       	$this->getSaver()->save($attributo);
       	
       	$repository = $this->getDm()->getRepository('FDT\MetadataBundle\Document\Attributi\AttributoTranslation');
        $translations = $repository->findTranslations($attributo);

        $this->assertEquals('Peso palla', $attributo->getName());
        $this->assertEquals('peso-palla', $attributo->getSlug());
        
        $attributo->setName ('Peso');
        
        $this->assertEquals('Peso', $attributo->getName());
       	$this->assertEquals('peso-palla', $attributo->getSlug());
       	
       	$attributoSaved = $this->getSaver()->save($attributo);
       	
       	$this->assertEquals('peso-palla', $attributoSaved->getSlug());
       	
       	$attributoResult = $this->getDm()->createQueryBuilder('FDT\MetadataBundle\Document\Attributi\Attributo')
                           ->field('uniqueSlug')->equals('peso-visibile')
                           ->getQuery()
                           ->getSingleResult();
        
        
       	$this->assertEquals('peso-palla', $attributoResult->getSlug());
       	
       	
    }
    
    public function testTranslateAttributo()
    {
        $attributo = new Attributo ();
       	$attributo->setName ('Peso palla');
       	$attributo->setDescrizione ('descrizione');
       	$attributo->setUniqueName ('Peso tradotto');
       	$attributo->setTipo ('text');
       	
       	$this->getSaver()->save($attributo);
       	
       	$attributoResult = $this->getDm()->getRepository('FDT\MetadataBundle\Document\Attributi\Attributo')->findOneBy (array ('uniqueSlug'=>'peso-tradotto'));
        
        $attributoResult->setName('Peso It');
        $attributoResult->setDescrizione ('Descrizione it');
        $attributoResult->setTranslatableLocale('it_it');
        
        $attributoSaved = $this->getSaver()->save($attributoResult);
                        
        $repository = $this->getDm()->getRepository('FDT\MetadataBundle\Document\Attributi\AttributoTranslation');
        $translations = $repository->findTranslations($attributoSaved);
        
        
        $this->assertArrayHasKey('en_us', $translations);
        $this->assertArrayHasKey('it_it', $translations);
        $this->assertEquals('peso-palla', $translations['en_us']['slug']);
        $this->assertEquals('peso-it', $translations['it_it']['slug']);
        
       	
    }
    
    public function testNewTranslation()
    {
        $attributo = new Attributo ();
       	$attributo->setName ('Peso palla');
       	$attributo->setDescrizione ('descrizione');
       	$attributo->setUniqueName ('Peso tradotto');
       	$attributo->setTipo ('text');
       	
       	$attributo = $this->getSaver()->save($attributo);
       	
       	$attributo->setTranslatableLocale('it_it');
       	$attributo->setName('Peso It');
        $attributo->setDescrizione ('Descrizione it');
        
        $attributo = $this->getSaver()->save($attributo);
        
        $repository = $this->getDm()->getRepository('FDT\MetadataBundle\Document\Attributi\AttributoTranslation');
        $translations = $repository->findTranslations($attributo);
        
        
        $this->assertArrayHasKey('en_us', $translations);
        $this->assertArrayHasKey('it_it', $translations);
        $this->assertEquals('peso-palla', $translations['en_us']['slug']);
        $this->assertEquals('peso-it', $translations['it_it']['slug']);
        
        
       	
       	
    }
    

        
    

}