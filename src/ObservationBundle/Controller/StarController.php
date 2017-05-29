<?php


namespace ObservationBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StarController extends Controller
{
    public function listAction()
    {
        if($this->getUser()->hasRole('ROLE_NATURALISTE')){
            throw $this->createAccessDeniedException("Vous ne disposer pas des droits d'accès !");
        }
        $em = $this->getDoctrine()->getManager();

        $stars = $em->getRepository('ObservationBundle:Star')->findAll();

        $device = $this->get('mobile_detect.mobile_detector');
        if ($device->isMobile()){
            return $this->render('@Observation/Star/Mobile/list.html.twig', array('stars' => $stars));
        }else{
            return $this->render('@Observation/Star/Desktop/list.html.twig', array('stars' => $stars));
        }
    }
}