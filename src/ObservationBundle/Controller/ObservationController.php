<?php


namespace ObservationBundle\Controller;


use ObservationBundle\Entity\Location;
use ObservationBundle\Entity\Observation;
use ObservationBundle\Form\Location\LocationType;
use ObservationBundle\Form\Observation\AddObservationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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

    public function addAction(Request $request)
    {
        $observation = new Observation();
        //On récupère les infos pour chaque visiteurs liés à cette reservation
        $allBirds = $this->getDoctrine()->getManager()->getRepository('ObservationBundle:Bird')->findAll();

        $form = $this->createForm(AddObservationType::class, $observation, array('listBirds' => $allBirds->getNomVern()));

        $form->handleRequest($request);



        foreach ($allBirds as $bird){

            $listBirds [] = $bird->getNomVern();

        }


        if ($form->isSubmitted() && $form->isValid()) {

            echo 'test Reussi';
            return $this->redirectToRoute('observation_list');
        }
        $device = $this->get('mobile_detect.mobile_detector');
        if($device->isMobile()){
            return $this->render(
            'ObservationBundle:Observation:Mobile/add.html.twig', array(
            'form' => $form->createView()));
        }else{
            return $this->render(
            'ObservationBundle:Observation:Desktop/add.html.twig', array(
            'form' => $form->createView(),
                'list' => $listBirds));
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