<?php
namespace FDT\MetadataBundle\Utilities\Attributi;

use Symfony\Component\Config\Definition\Processor;
use FDT\MetadataBundle\DependencyInjection\Configuration;

class AttributiCallbacks
{
    
    public function getArrayTypes ()
    {
        $processor = new Processor();
        $configuration = new Configuration(true);
        
        $arrayConfiguration = ($processor->processConfiguration ($configuration, array()));
        
        return ($arrayConfiguration['attributi_type']['attributi']);
        
    
    }

    public static function getTypes ()
    {
        $self = new AttributiCallbacks;
        
        $arrayTypes = $self->getArrayTypes ();
        $arrayForChoise = array();
        
        foreach ($arrayTypes as $type=>$name)
        {
        
            $arrayForChoise[] = $type;
        
        }
    
        return $arrayForChoise;
    
    
    }



}