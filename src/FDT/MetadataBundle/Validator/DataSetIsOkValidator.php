<?php
namespace FDT\MetadataBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\HttpFoundation\Request;


class DataSetIsOkValidator extends \Symfony\Component\Validator\ConstraintValidator
{

    public function isValid($value = NULL, Constraint $constraint)
    {
        if (is_null($value))
        {
           return TRUE; 
        }
        $type = $this->context->getRoot()->getTipo();
        
        if (in_array($type, $constraint->validType))
        {
            return TRUE;            
        }

        $this->setMessage($constraint->message);

        return FALSE;
    }
    
    
}