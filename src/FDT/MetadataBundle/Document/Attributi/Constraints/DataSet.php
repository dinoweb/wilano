<?php
namespace Symfony\Component\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
* 
*/
class DataSet extends Constraint
{
    public $message = 'Si puo associare un dataset solo ad attributi di tipo singleSelect e multipleSelect';
    public $protocols = array('singleSelect', 'multipleSelect');
}
