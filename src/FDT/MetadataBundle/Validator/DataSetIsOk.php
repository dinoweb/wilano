<?php
namespace FDT\MetadataBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
*@Annotation 
*/
class DataSetIsOk extends Constraint
{
    public $message = 'Si puo associare un dataset solo ad attributi di tipo singleSelect e multipleSelect';
    public $validType = array('singleSelect', 'multipleSelect');
    
    public function validatedBy()
    {
        return 'attributi_dataSetIsOk';
    }
}
