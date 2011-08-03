<?php
namespace FDT\MetadataBundle\Document\Contenuti;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(collection="contenuti.prodotti", repositoryClass="FDT\MetadataBundle\Document\Contenuti\ProdottiRepository");
 */
class Prodotti extends BaseContenuto
{
    
    /** @MongoDB\Id(strategy="INCREMENT") */
    private $id;
    

}