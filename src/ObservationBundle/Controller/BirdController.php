<?php


namespace ObservationBundle\Controller;


use ObservationBundle\Entity\Bird;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ObservationBundle\Entity\Observation;
use ObservationBundle\Form\Observation\AddObservationType;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use ObservationBundle\Entity\Picture;


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

    public function observationAction(Bird $bird, Request $request)
    {

        $birdId = $bird->getId();
        $observation = new Observation();
        $session = new Session();
        $session->set('getBird', true);
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(AddObservationType::class, $observation);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $files = $form->get('files')->getData();

            foreach ($files as $file) {
                $picture = new Picture();
                $picture->setFile($file)
                    ->setObservation($observation)
                    ->setBird($bird);

            }

            $observation->setPostedAt(new \DateTime('now'));

            $observation->setUser($this->getUser());
            $observation->setBird($bird);

            $em->persist($observation);
            $em->flush();

            $this->addFlash(
                'notice',
                'Votre observation a été envoyé! En attente de validation'
            );

            return $this->redirectToRoute('bird_observation', array('id' => $birdId));
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

    /**
     * Action pemrettant de générer une page de liste d'oiseau avec ou sans recherche
     * @param $page
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function paginationAction($page, Request $request)
    {
        // On vérifie s'il s'agit d'une reuqete ajax
        if ($request->isXmlHttpRequest()){
            // On verfie le numero de la page
            // Superieur à 0, on recuper la liste
            if($page > 0){
                // On définit la quantité d'oiseaux
                $number = 20;
                $em= $this->getDoctrine()->getManager();

                // On calcule la taille de search,
                // Si c'est 0, search est null,
                // Sinon on lui passe la valeur sécurisé
                $search = strlen(htmlspecialchars($request->query->get('search'))) == 0 ? null :  htmlspecialchars($request->query->get('search'));

                // On effectu la requete doctrine getPage()
                $birds = $em->getRepository('ObservationBundle:Bird')->getPage($page, $number, $search);
                // On calcul le nombre de page max
                $nbPage = ceil(count($birds)/$number);

                if($nbPage < 1 && $nbPage < $page){
                    // Si le nombre de page est inferieur à 1 ou superieur à la page, on mets tout à null
                    $birds = null;
                    $nbPage = null;
                }
            }else{
                // Sinon on passe tout à null
                $birds = null;
                $nbPage = null;
            }
            $device = $this->get('mobile_detect.mobile_detector');
            if($device->isMobile()){
                return $this->render('@Observation/Bird/Mobile/page.html.twig', array('birds' => $birds, 'nbPage' => $nbPage, 'page' => $page, 'number' => $number));
            }else{
                return $this->render('@Observation/Bird/Desktop/page.html.twig', array('birds' => $birds, 'nbPage' => $nbPage, 'page' => $page, 'number' => $number));
            }
        }else{
            throw $this->createAccessDeniedException('Vous n\'avez pas le droit d\'être içi !');
        }
    }
}