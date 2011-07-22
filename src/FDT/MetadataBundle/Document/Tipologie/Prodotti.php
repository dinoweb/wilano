<?php
namespace FDT\MetadataBundle\Document\Tipologie;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(collection="tipologie.prodotti", repositoryClass="FDT\MetadataBundle\Document\Tipologie\ProdottiRepository");
 */
 
class Prodotti extends BaseTipologia
{
    
    /** @MongoDB\Id(strategy="AUTO") */
    private $id;
    

}