<?php

namespace ObservationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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

    public function contactAction(Request $request)
    {
        $device = $this->get('mobile_detect.mobile_detector');
        if($device->isMobile()){
            return $this->render('@Observation/Association/Mobile/contact.html.twig');
        }else{
            return $this->render('@Observation/Association/Desktop/contact.html.twig');
        }
    }

    public function faqAction()
    {
        $device = $this->get('mobile_detect.mobile_detector');
        if($device->isMobile()){
            return $this->render('@Observation/Association/Mobile/faq.html.twig');
        }else{
            return $this->render('@Observation/Association/Desktop/faq.html.twig');
        }
    }
}
