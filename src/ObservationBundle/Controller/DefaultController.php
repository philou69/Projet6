<?php

namespace ObservationBundle\Controller;

use ObservationBundle\Entity\Picture;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $pictures = new Picture();

        $gallery = $em->getRepository('ObservationBundle:Picture')->getPictureGallery();

        $device = $this->get('mobile_detect.mobile_detector');
        if($device->isMobile() || $device->isTablet()){

            return $this->render('@Observation/Home/Mobile/home.html.twig', array('gallery' => $gallery));
        }else{
            return $this->render('@Observation/Home/Desktop/home.html.twig', array('gallery' => $gallery));
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
