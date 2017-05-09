<?php


namespace ObservationBundle\Controller;


use ObservationBundle\Entity\Observation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ObservationController extends Controller
{
    public function listAction()
    {
        $device = $this->get('mobile_detect.mobile_detector');
        if($device->isMobile()){
            return $this->render('@Observation/Observation/Mobile/list.html.twig');
        }else{
            return $this->render('@Observation/Observation/Desktop/list.html.twig');
        }
    }

    public function viewAction(Observation $observation)
    {
        $device = $this->get('mobile_detect.mobile_detector');
        if($device->isMobile()){
            return $this->render('@Observation/Observation/Mobile/view.html.twig');
        }else{
            return $this->render('@Observation/Observation/Desktop/view.html.twig');
        }
    }

    public function addAction()
    {
        $device = $this->get('mobile_detect.mobile_detector');
        if($device->isMobile()){
            return $this->render('@Observation/Observation/Mobile/add.html.twig');
        }else{
            return $this->render('@Observation/Observation/Desktop/add.html.twig');
        }
    }

    /**
     * @Security(has_role('ROLE_NATURALISTE')
     */
    public function validateAction(Observation $observation)
    {
        // Action simple de mise à jour de l'entity sans vue renvoyant à la page de l'observation
    }

    /**
     * @Security(has_role('ROLE_NATURALISTE)
     */
    public function unvalideAction(Observation $observation)
    {
        // Action simple de mise à jour de l'entity sans vue renvoyant à la page de l'observation
    }
}