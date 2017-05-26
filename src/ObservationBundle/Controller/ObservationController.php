<?php


namespace ObservationBundle\Controller;


use ObservationBundle\Entity\Bird;
use ObservationBundle\Entity\Location;
use ObservationBundle\Entity\Observation;
use ObservationBundle\Entity\User;
use ObservationBundle\Form\Bird\BirdType;
use ObservationBundle\Form\Location\LocationType;
use ObservationBundle\Form\Observation\AddObservationType;
use Proxies\__CG__\ObservationBundle\Entity\Birds;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Date;

class ObservationController extends Controller
{
    /**
     *  Action de pagination des observations soit générale soit de l'utilisateur
     * @param $status
     * @param $page
     * @param $all
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function paginationAction($status, $page, $all)
    {
        // On s'asusre que validate et all soient bien des boolean
        $validate = $status == 'true' ? true : false;
        $all = $all == 'true' ? true: false;
        // Si la page est inferieur à 1 on passe tout à null et gérera les erreurs coté affichage étant donné qu'il s'agit de requete AJAX
        if($page < 1){
            $observations = null;
            $nbPage = null;
        }else{
            $em = $this->getDoctrine()->getManager();
            // On récupere la liste des observations et on calcul le nombre de pages maximum en fonction de la limite de 10
            $observations = $em->getRepository('ObservationBundle:Observation')->findObs($validate,$this->getUser(), $page, 1, $all);
            $nbPage = ceil(count($observations) / 1);
            // Si lapage est surperieur au nombre de page ou que le nombre de page est 0, on passe tout à null
            if($nbPage < $page || $nbPage == 0){
                $observations = null;
                $nbPage = null;
            }
        }

        $device = $this->get('mobile_detect.mobile_detector');
        if($device->isMobile()){
            return $this->render('@Observation/Observation/Mobile/page.html.twig', array('observations' => $observations, 'page' => $page, 'nbPage' => $nbPage, 'status' => $status, 'all' => $all));
        }else{
            return $this->render('@Observation/Observation/Desktop/page.html.twig', array('observations' => $observations, 'page' => $page, 'nbPage' => $nbPage, 'status' => $status, 'all' => $all));
        }

    }

    public function birdPaginationAction(Bird $bird, $page)
    {
        if($page < 1){
            $observations = null;
            $nbPage = null;
        }else{
            $em = $this->getDoctrine()->getManager();
            $observations = $em->getRepository('ObservationBundle:Observation')->findsByBird($bird, $page, 4);

            $nbPage = ceil(count($observations) / 4);
            if($nbPage < $page){
                $observations = null;
                $nbPage = null;
            }
        }
        return $this->render('@Observation/Observation/bird.page.html.twig', array('observations' => $observations, 'page' => $page, 'nbPage' => $nbPage, 'bird' => $bird));

        $device = $this->get('mobile_detect.mobile_detector');
        if($device->isMobile()){
            return $this->render('@Observation/Observation/Mobile/bird.page.html.twig', array('observations' => $observations, 'page' => $page, 'nbPage' => $nbPage, 'bird' => $bird));
        }else{
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