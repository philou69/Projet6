<?php


namespace ObservationBundle\Controller;


use ObservationBundle\Entity\Bird;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ObservationBundle\Entity\Observation;
use ObservationBundle\Form\Observation\AddObservationType;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


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

    public function observationAction(Bird $bird, Request $request)
    {

        $user = $this->getUser();
        if($user === null){
            throw new Exception('Vous n\'êtes pas autoriser à venir içi');
        }

        $birdId = $bird->getId();
        $observation = new Observation();
        $session = new Session();
        $session->set('getBird', true);
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(AddObservationType::class, $observation);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $name = $observation->getBird()->getLbNom();
            $observationId = $observation->getId();

            $observation->setPostedAt(new \DateTime('now'));
            $observation->setBird($bird);

            $observation->setUser($user);

            $em->persist($observation);
            $em->flush();

            $device = $this->get('mobile_detect.mobile_detector');
            if($device->isMobile()){
                return $this->render('@Observation/Observation/Mobile/view.html.twig', array('id' => $observationId));
            }else{
                return $this->render('@Observation/Observation/Mobile/view.html.twig', array('id' => $observationId));
            }
        }

        $device = $this->get('mobile_detect.mobile_detector');
        if($device->isMobile()){
            return $this->render('@Observation/Observation/Mobile/add.html.twig', array('id' => $birdId,
                'bird' => $bird,
                'form' => $form->createView()));
        }else{
            return $this->render('@Observation/Observation/Desktop/add.html.twig', array('id' => $birdId,
                'bird' => $bird,
                'form' => $form->createView()));
        }

    }
}