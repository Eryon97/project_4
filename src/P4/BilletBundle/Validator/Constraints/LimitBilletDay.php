<?php 

namespace P4\BilletBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
* @Annotation
*/
class LimitBilletDay extends Constraint 
{
    public function validatedBy()
    {
        return 'p4_billet_limitbilletday';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    } 
}