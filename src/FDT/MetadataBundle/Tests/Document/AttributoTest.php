<?php

namespace FDT\MetadataBundle\Tests\Document;

use FDT\MetadataBundle\Document\Attributi\Attributo;
use FDT\AdminBundle\Tests\TestCase\TestCase;


class AttributoTest extends TestCase
{
    

    public function testAddAttributo ()
    {
    	
    	$attributo = new Attributo ();
       	$attributo->setName ('Peso');
       	$attributo->setVisibleName ('Peso visibile');
       	$attributo->setTipo ('weigth');
       	
       	$this->getDm()->persist($attributo);
       	$this->getDm()->flush ();
       	
       	$attributoResult = $this->getDm()->createQueryBuilder('FDT\MetadataBundle\Document\Attributi\Attributo')
                           ->field('name')->equals('Peso')
                           ->getQuery()
                           ->getSingleResult();
       	       	
       	$this->assertTrue ($attributoResult->isActive());
       	
       	$attributoResult->setIsActive(false);
       	$this->getDm()->flush ();
       	
       	$attributoResult2 = $this->getDm()->createQueryBuilder('FDT\MetadataBundle\Document\Attributi\Attributo')
                           ->field('name')->equals('Peso')
                           ->getQuery()
                           ->getSingleResult();
       	       	
       	$this->assertFalse ($attributoResult2->isActive());
    
    
    }    
    

}