<?php


namespace ObservationBundle\Controller;


use ObservationBundle\Entity\Bird;
use ObservationBundle\Entity\Observation;
use ObservationBundle\Entity\Picture;
use ObservationBundle\Event\ObservationEvent;
use ObservationBundle\Form\Observation\AddObservationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


class ObservationController extends Controller
{
    /**
     *  Action de pagination des observations soit générale soit de l'utilisateur
     * @param $status
     * @param $page
     * @param $all
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function paginationAction($status, $page, $all, Request $request)
    {
        // On s'assure qu'il s'agisse d'une requête AJAX
        if($request->isXmlHttpRequest()){
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
                $observations = $em->getRepository('ObservationBundle:Observation')->findObs($validate,$this->getUser(), $page, 10, $all);
                $nbPage = ceil(count($observations) / 10);
                // Si lapage est surperieur au nombre de page ou que le nombre de page est 0, on passe tout à null
                if($nbPage < $page || $nbPage == 0){
                    $observations = null;
                    $nbPage = null;
                }
            }
            // On retourne la même vue quelque soit le device
            return $this->render('ObservationBundle:Observation:page.html.twig', array('observations' => $observations, 'page' => $page, 'nbPage' => $nbPage, 'status' => $status, 'all' => $all));
        }else{
            throw $this->createAccessDeniedException('Vous ne pouvez pas acceder à cette page !');
        }
    }

    /**
     * Action pour générer la pagination des observation d'un oiseau
     * @param Bird $bird
     * @param $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function birdPaginationAction(Bird $bird, $page, Request $request)
    {
        // On s'assure d'être en requete AJAX
        if($request->isXmlHttpRequest()){
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
            // On retourne la même vue quelque soit le device
            return $this->render('@Observation/Observation/bird.page.html.twig', array('observations' => $observations, 'page' => $page, 'nbPage' => $nbPage, 'bird' => $bird));
        }else{
            throw $this->createAccessDeniedException('Vous ne pouvez pas acceder à cette page !');
        }

    }


    /**
     * Action pour voir une observation sur un oiseau
     * @param Observation $observation
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(Observation $observation, Request $request)
    {
            return $this->render('@Observation/Observation/detail.html.twig', array(
                'observation' => $observation
            ));
    }

    /**
     * Action pour ajouter une observation sur un oiseau
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {

        $observation = new Observation();
        $session = new Session();
        $session->set('getBird', false);
        $em = $this->getDoctrine()->getManager();

        // On verifie si le visiteur est un naturaliste
        if($this->getUser()->hasRole('ROLE_NATURALISTE')){
            // Dans ce cas, l'observation est automatiquement validé par lui-même
            $observation->setValidated(true)
                ->setValidatedAt(new \DateTime())
                ->setValidatedBy($this->getUser());
        }
        $form = $this->createForm(AddObservationType::class, $observation);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // Recuperation des photos uploader
            $files = $form->get('pictures')->getData();

            // On boucle sur les photos pour les ajoutés à l'observation
            foreach ($files as $file) {
                $picture = new Picture();
                $picture->setFile($file)
                    ->setObservation($observation);
                // Si l'observation est dejà validé, on ajoute l'oiseau à la photo.
                if ($observation->getValidated() == true) {
                    $picture->setBird($observation->getBird());
                }
                $em->persist($picture);
            }



            $observation->setUser($this->getUser());


            $em->persist($observation);
            $em->flush();

            $this->addFlash(
                'success',
                'Votre observation a été envoyée! En attente de validation'
            );
            return $this->redirectToRoute('observation_add');
        }

        $device = $this->get('mobile_detect.mobile_detector');
        if($device->isMobile() || $device->isTablet()){
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
     * @Security("has_role('ROLE_NATURALISTE')")
     */
    public function validateAction(Observation $observation)
    {
        // Action simple de mise à jour de l'entity sans vue renvoyant à la page de l'observation
        // on passe l'observation en validé
        $observation->setValidated(true)
            ->setValidatedAt(new \DateTime())
            ->setValidatedBy($this->getUser());
        foreach ($observation->getPictures() as $picture)
        {
            $picture->setBird($observation->getBird());
        }
        $em = $this->getDoctrine()->getManager();

        $em->persist($observation);
        $em->flush();
        $this->get('event_dispatcher')->dispatch('observation.captured', new ObservationEvent($observation));

        $this->addFlash('info', "L'observation a bien été enregistrée !");

        return $this->redirectToRoute('observation_view', array('id' => $observation->getId()));

    }

    /**
     * @Security("has_role('ROLE_NATURALISTE')")
     */
    public function unvalideAction(Observation $observation)
    {
        // Action simple de mise à jour de l'entity sans vue renvoyant à la page de l'observation
        // On va retirer l'oiseau des photos de l'observation
        foreach ($observation->getPictures() as $picture) {
            $picture->setBird(null);
        }
        $observation->setValidated(false)
        ->setValidatedBy(null)
        ->setValidatedAt(null);
        $em = $this->getDoctrine()->getManager();

        $em->persist($observation);
        $em->flush();

        $this->addFlash('success', 'L\'observation a bien été invalidée');
        return $this->redirectToRoute('observation_view', array('id' => $observation->getId()));

    }

    /**
     * Action pour générer les points de localisation d'un oiseau
     * @param Bird $bird
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function locationsAction(Bird $bird, Request $request)
    {
        // On s'assure d'être en requete AJAX
        if ($request->isXmlHttpRequest()) {

            $em = $this->getDoctrine()->getManager();
            $locations = $em->getRepository('ObservationBundle:Location')->findBirdLocations($bird);

            $response = new JsonResponse($locations);


            return $response;
        }
    }
}