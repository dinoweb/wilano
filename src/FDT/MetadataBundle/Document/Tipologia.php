<?php
namespace FDT\MetadataBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use FDT\doctrineExtensions\NestedSet\Documents\BaseNode;

/**
 * @MongoDB\Document(collection="tipologie")
 */
class Tipologia extends BaseNode
{
    
    /** @MongoDB\String */
    protected $name;
    
    
    
    /**
     * setName function.
     * 
     * @access public
     * @param mixed $name
     * @return void
     */
    public function setName ($name)
    {
    
        $this->name = $name;
    
    }
    
    /**
     * getName function.
     * 
     * @access public
     * @return string name
     */
    public function getName ()
    {
    
        return $this->name;
    
    }

}

