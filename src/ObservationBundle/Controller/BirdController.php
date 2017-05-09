<?php


namespace ObservationBundle\Controller;


use ObservationBundle\Entity\Birds;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BirdController extends Controller
{
    public function listAction()
    {
        $device = $this->get('mobile_detect.mobile_detector');
        if($device->isMobile()){
            return $this->render('@Observation/Bird/Mobile/list.html.twig');
        }else{
            return $this->render('@Observation/Bird/Desktop/list.html.twig');
        }
    }

    public function descripitionAction(Birds $bird)
    {
        $device = $this->get('mobile_detect.mobile_detector');
        if($device->isMobile()){
            return $this->render('@Observation/Bird/Mobile/description.html.twig', array('bird' => $bird));
        }else{
            return $this->render('@Observation/Bird/Desktop/description.html.twig', array('bird' => $bird));
        }
    }

    public function locationAction(Birds $bird)
    {
        $device = $this->get('mobile_detect.mobile_detector');
        if($device->isMobile()){
            return $this->render('@Observation/Bird/Mobile/location.html.twig', array('bird' => $bird));
        }else{
            return $this->render('@Observation/Bird/Desktop/location.html.twig', array('bird' => $bird));
        }
    }
}