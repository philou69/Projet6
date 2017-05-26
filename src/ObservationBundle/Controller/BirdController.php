<?php


namespace ObservationBundle\Controller;


use ObservationBundle\Entity\Bird;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BirdController extends Controller
{
    public function listAction(Request $request)
    {
        $device = $this->get('mobile_detect.mobile_detector');
        if($device->isMobile()){
            return $this->render('@Observation/Bird/Mobile/list.html.twig');
        }else{
            return $this->render('@Observation/Bird/Desktop/list.html.twig');
        }
    }


    public function descripitionAction(Bird $bird)
    {
        $device = $this->get('mobile_detect.mobile_detector');
        if($device->isMobile()){
            return $this->render('@Observation/Bird/Mobile/description.html.twig', array('bird' => $bird));
        }else{
            return $this->render('@Observation/Bird/Desktop/description.html.twig', array('bird' => $bird));
        }
    }

    public function locationAction(Bird $bird)
    {
        $device = $this->get('mobile_detect.mobile_detector');
        if($device->isMobile()){
            return $this->render('@Observation/Bird/Mobile/location.html.twig', array('bird' => $bird));
        }else{
            return $this->render('@Observation/Bird/Desktop/location.html.twig', array('bird' => $bird));
        }
    }

    public function paginationAction($page, Request $request)
    {
        if($page > 0){
            $number = 20;
            $em= $this->getDoctrine()->getManager();

            // On calcule la taille de search,
            // Si c'est 0, search est null,
            // Sinon on lui passe la valeur sécurisé
            $search = strlen(htmlspecialchars($request->query->get('search'))) == 0 ? null :  htmlspecialchars($request->query->get('search'));

            $birds = $em->getRepository('ObservationBundle:Bird')->getPage($page, $number, $search);
            $nbPage = ceil(count($birds)/$number);
            if($nbPage < 1){
                $birds = null;
                $nbPage = null;
            }
        }else{
            $birds = null;
            $nbPage = null;
        }
        $device = $this->get('mobile_detect.mobile_detector');
        if($device->isMobile()){
            return $this->render('@Observation/Bird/Mobile/page.html.twig', array('birds' => $birds, 'nbPage' => $nbPage, 'page' => $page, 'number' => $number));
        }else{
            return $this->render('@Observation/Bird/Desktop/page.html.twig', array('birds' => $birds, 'nbPage' => $nbPage, 'page' => $page, 'number' => $number));
        }
    }
}