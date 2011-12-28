<?php

namespace FDT\MetadataBundle\Tests\Document\Attributi;

use FDT\MetadataBundle\Document\Attributi\DataSet;
use FDT\MetadataBundle\Document\Attributi\Option;
use FDT\AdminBundle\Tests\TestCase\TestCase;
use FDT\MetadataBundle\Exception\ValidatorErrorException;


class DataSetTest extends TestCase
{

    public function testAddDataSet ()
    {
    	
    	$dataSet = new DataSet ();
       	$dataSet->setName ('Nazioni');
       	$dataSet->setDescrizione ('Elenco nazioni');
       	$dataSet->setUniqueName ('Nazioni unique name');       	
       	
       	$this->getSaver()->save($dataSet);
       	
       	$dataSetResult = $this->getDm()->createQueryBuilder('FDT\MetadataBundle\Document\Attributi\DataSet')
                           ->field('uniqueSlug')->equals('nazioni-unique-name')
                           ->getQuery()
                           ->getSingleResult();
       	       	
       	$this->assertEquals ('nazioni-unique-name', $dataSetResult->getUniqueSlug());
       	
       	$dataSet->setName ('Nazioni risalvato');
       	$this->getSaver()->save($dataSet);
       	
       	
       	$dataSetResult2 = $this->getDm()->createQueryBuilder('FDT\MetadataBundle\Document\Attributi\DataSet')
                           ->field('uniqueSlug')->equals('nazioni-unique-name')
                           ->getQuery()
                           ->getSingleResult();
       	       	
       	$this->assertEquals ('nazioni-unique-name', $dataSetResult2->getUniqueSlug());
       	
       	$repository = $this->getDm()->getRepository('FDT\MetadataBundle\Document\Attributi\DataSetTranslation');
        $translations = $repository->findTranslations($dataSetResult2);
                
        $this->assertEquals('nazioni-unique-name', $dataSetResult2->getUniqueSlug());
        $this->assertArrayHasKey('en_us', $translations);
        $this->assertEquals('nazioni-risalvato', $translations['en_us']['slug']);
               	
       	    
    
    }
    
    
    public function testNewTranslation()
    {
  
        $dataSet = new DataSet ();
       	$dataSet->setName ('Peso palla');
       	$dataSet->setDescrizione ('descrizione');
       	$dataSet->setUniqueName ('Peso tradotto');
       	
       	$dataSet = $this->getSaver()->save($dataSet);
       	
       	$dataSet->setTranslatableLocale('it_it');
       	$dataSet->setName('Peso It');
        $dataSet->setDescrizione ('Descrizione it');
        
        $dataSet = $this->getSaver()->save($dataSet);
        
        $repository = $this->getDm()->getRepository('FDT\MetadataBundle\Document\Attributi\DataSetTranslation');
        $translations = $repository->findTranslations($dataSet);
        
        
        $this->assertArrayHasKey('en_us', $translations);
        $this->assertArrayHasKey('it_it', $translations);
        $this->assertEquals('peso-palla', $translations['en_us']['slug']);
        $this->assertEquals('peso-it', $translations['it_it']['slug']);
        
        
       	
       	
    }
    
    public function testOptions()
    {
        $dataSet = new DataSet ();
       	$dataSet->setName ('Nazioni');
       	$dataSet->setDescrizione ('nazioni per le spedizioni');
       	$dataSet->setUniqueName ('Peso tradotto');
       	
       	$option = new Option;
        $option->setName('Italia');
        $option->setValue('IT');
        $option->setOrdine(10);
        
        
        $option1 = new Option;
        $option1->setName('Stati Uniti');
        $option1->setValue('US');
        $option1->setOrdine(20);
        
        $option2 = new Option;
        $option2->setName('Francia');
        $option2->setValue('FR');
        $option2->setOrdine(2);
        
        
        $dataSet->addOption ($option);
        $dataSet->addOption ($option1);
        $dataSet->addOption ($option2);
        
        $dataSet = $this->getSaver()->save($dataSet);
        
            
        $this->assertEquals (3, $dataSet->getOptions()->count ());
        
        $arrayOptions = $dataSet->getOptions()->toArray ();
        $first = array_shift($arrayOptions);
        
        $this->assertEquals ('Francia', $first->getName());
        
        $second = array_shift($arrayOptions);
        
        $this->assertEquals ('Italia', $second->getName());
        
        $this->assertEquals ('Stati Uniti', $arrayOptions[0]->getName());
        
        $repository = $this->getDm()->getRepository('FDT\MetadataBundle\Document\Attributi\OptionTranslation');
        $translations = $repository->findTranslations($option2);
        $this->assertEquals (1, count ($translations));
        
        
        
        
        
    }
    

        
    

}