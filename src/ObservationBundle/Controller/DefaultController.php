<?php

namespace ObservationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ObservationBundle:Default:layout.html.twig');
    }
}
