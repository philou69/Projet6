<?php


namespace ObservationBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BirdController extends Controller
{
    public function listAction()
    {
        return $this->render(
            'ObservationBundle:Birds:Desktop/list.html.twig');

    }
}