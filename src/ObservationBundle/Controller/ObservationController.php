<?php


namespace ObservationBundle\Controller;


use ObservationBundle\Entity\Observation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ObservationController extends Controller
{
    public function listAction()
    {

    }

    public function viewAction(Observation $observation)
    {

    }

    public function addAction()
    {

    }

    /**
     * @Security(has_role('ROLE_NATURALISTE')
     */
    public function validateAction(Observation $observation)
    {

    }

    /**
     * @Security(has_role('ROLE_NATURALISTE)
     */
    public function unvalideAction(Observation $observation)
    {

    }
}