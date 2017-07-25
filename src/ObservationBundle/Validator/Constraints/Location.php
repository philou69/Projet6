<?php


namespace ObservationBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Location extends Constraint
{
    public $message = "Le lieu signaler n'est pas correct";

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }

    public function getTargets()
    {
        return Constraint::CLASS_CONSTRAINT;
    }
}