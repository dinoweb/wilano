<?php
namespace FDT\MetadataBundle\Utilities\Attributi;

class AttributiCallbacks
{
    
    public function getArrayTypes ()
    {
        
        return array ('text'=>'Text',
                      'textTranslation' => 'Text con traduzione',
                      'textarea'=> 'TextArea',
                      'textareaTranslation'=> 'TextArea con traduzione',
                      'textareaHtml'=>'TextArea Html',
                      'textareaHtmlTranslation'=>'TextArea Html con traduzione',
                      'number'=>'Number',
                      'decimal'=>'Decimal',
                      'boolean'=>'Boolean',
                      'data'=>'Data',
                      'email'=>'E-Mail',
                      'immagine'=>'Immagine',
                      'documento'=>'Documento',
                      'singleSelect'=>'SingleSelect',
                      'multipleSelect'=>'MultipleSelect',
                      'weight'=>'Weight',
                      'length'=>'Length',
                      'cap'=>'Cap'
                      );
    
    
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