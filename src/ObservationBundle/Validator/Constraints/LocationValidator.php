<?php


namespace ObservationBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class LocationValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if($value->getLatitude() === null || $value->getLongitude() === null){
            $this->context->buildViolation($constraint->message)
                ->atPath('lieu')
                ->addViolation();
        }
    }
}