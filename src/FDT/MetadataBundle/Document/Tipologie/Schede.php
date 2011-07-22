<?php
namespace FDT\MetadataBundle\Document\Tipologie;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(collection="tipologie.schede");
 */
 
class Schede extends BaseTipologia
{

    /** @MongoDB\Id(strategy="AUTO") */
    private $id;

}