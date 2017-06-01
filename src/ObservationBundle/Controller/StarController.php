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

        $groupsStar = $em->getRepository('ObservationBundle:GroupStar')->findAll();

            return $this->render('@Observation/Star/list.html.twig', array('groupsStar' => $groupsStar));

    }
}