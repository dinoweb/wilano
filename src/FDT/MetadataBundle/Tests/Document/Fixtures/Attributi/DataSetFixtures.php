<?php

namespace FDT\MetadataBundle\Tests\Document\Fixtures\Attributi;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use FDT\MetadataBundle\Document\Attributi\Dataset;
use FDT\MetadataBundle\Document\Attributi\Option;


class DataSetFixtures extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    
    public function load($manager)
    {
        $dataSet = new DataSet ();
       	$dataSet->setName ('Nazioni');
       	$dataSet->setDescrizione ('nazioni per le spedizioni');
       	$dataSet->setUniqueName ('Nazioni');
       	$manager->persist($dataSet);
       	
       	$option = new Option;
        $option->setName('Italia');
        $option->setValue('IT');
        $option->setOrdine(10);
        $manager->persist($option);
        
        
        $option1 = new Option;
        $option1->setName('Stati Uniti');
        $option1->setValue('US');
        $option1->setOrdine(20);
        $manager->persist($option1);
        
        $option2 = new Option;
        $option2->setName('Francia');
        $option2->setValue('FR');
        $option2->setOrdine(2);
        $manager->persist($option2);
        
        
        $dataSet->addOption ($option);
        $dataSet->addOption ($option1);
        $dataSet->addOption ($option2);
       	
        $manager->persist($dataSet);
        $manager->flush();
        
        $this->addReference('dataset.nazioni', $dataSet);      	
    }
    
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }

 
}