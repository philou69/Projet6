<?php


namespace ObservationBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Fiche extends Constraint
{
    public $message = "Le maximum de spécimens ne peut être plus petit ou égal au minimum";

    public function validatedBy()
    {
        return get_class($this) . 'Validator';
    }

    public function getTargets()
    {
        return Constraint::CLASS_CONSTRAINT;
    }
}
