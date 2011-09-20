<?php
namespace FDT\MetadataBundle\Document\Attributi\Value;

use FDT\MetadataBundle\Document\Attributi\BaseAttributoValue;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\EmbeddedDocument
 */
class IntValue extends BaseAttributoValue
{
    /** @MongoDB\float */
    private $value;
}