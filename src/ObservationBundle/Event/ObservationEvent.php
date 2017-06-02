<?php
namespace ObservationBundle\Event;

use ObservationBundle\Entity\Observation;
use Symfony\Component\EventDispatcher\Event;

class ObservationEvent extends Event
{
    protected $observation;

    public function __construct(Observation $observation)
    {
        $this->observation = $observation;
    }

    public function getObservation()
    {
        return $this->observation;
    }
}