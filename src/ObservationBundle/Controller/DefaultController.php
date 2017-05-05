<?php

namespace ObservationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $device = $this->get('mobile_detect.mobile_detector');
        if($device->isMobile()){

            return $this->render('ObservationBundle::layout.mobile.html.twig');
        }else{
            return $this->render('ObservationBundle::layout.desktop.html.twig');
        }
    }
}
