<?php
namespace FDT\MetadataBundle\Document\Attributi\Value;

use FDT\MetadataBundle\Document\Attributi\BaseAttributoValue;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class TextValue extends BaseAttributoValue
{
    /**
     * @MongoDB\String
     * @Assert\NotBlank()
     * @var string
     */
    protected $value;

}