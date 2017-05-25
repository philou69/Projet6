<?php


namespace ObservationBundle\Controller;


use ObservationBundle\Entity\Bird;
use ObservationBundle\Entity\Location;
use ObservationBundle\Entity\Observation;
use ObservationBundle\Entity\User;
use ObservationBundle\Form\Bird\BirdType;
use ObservationBundle\Form\Location\LocationType;
use ObservationBundle\Form\Observation\AddObservationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Date;

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

        $user = $this->getUser();
        if($user === null){
            throw new Exception('Vous n\'êtes pas autoriser à venir içi');
        }

        $observation = new Observation();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(AddObservationType::class, $observation);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $observation->setPostedAt(new \DateTime('now'));

            $observation->setUser($user);

            $em->persist($observation);
            $em->flush();


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
            'form' => $form->createView()));
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