<?php


namespace ObservationBundle\Controller;


use DoctrineExtensions\Query\Mysql\Pi;
use ObservationBundle\Entity\Bird;
use ObservationBundle\Entity\Fiche;
use ObservationBundle\Entity\Location;
use ObservationBundle\Form\Type\Picture\PictureType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ObservationBundle\Entity\Observation;
use ObservationBundle\Form\Type\Observation\AddObservationType;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use ObservationBundle\Entity\Picture;
use ObservationBundle\Form\Type\Fiche\FicheType;


class BirdController extends Controller
{
    public function listAction(Request $request)
    {
        $device = $this->get('mobile_detect.mobile_detector');
        if ($device->isMobile() || $device->isTablet()) {
            return $this->render('@Observation/Bird/Mobile/list.html.twig');
        } else {
            return $this->render('@Observation/Bird/Desktop/list.html.twig');
        }
    }


    public function descripitionAction(Bird $bird)
    {
        $device = $this->get('mobile_detect.mobile_detector');
        if ($device->isMobile() || $device->isTablet()) {
            return $this->render('@Observation/Bird/Mobile/description.html.twig', array('bird' => $bird));
        } else {
            return $this->render('@Observation/Bird/Desktop/description.html.twig', array('bird' => $bird));
        }
    }

    public function locationAction(Bird $bird)
    {
        $device = $this->get('mobile_detect.mobile_detector');
        if ($device->isMobile() || $device->isTablet()) {
            return $this->render('@Observation/Bird/Mobile/location.html.twig', array('bird' => $bird));
        } else {
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
                'success',
                'Votre observation a été envoyé! En attente de validation'
            );

            return $this->redirectToRoute('bird_observation', array('id' => $birdId));
        }

        $device = $this->get('mobile_detect.mobile_detector');
        if ($device->isMobile() || $device->isTablet()) {
            return $this->render(
                '@Observation/Observation/Mobile/add.html.twig',
                array(
                    'id' => $birdId,
                    'bird' => $bird,
                    'form' => $form->createView(),
                )
            );
        } else {
            return $this->render(
                '@Observation/Observation/Desktop/add.html.twig',
                array(
                    'id' => $birdId,
                    'bird' => $bird,
                    'form' => $form->createView(),
                )
            );
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
        if ($request->isXmlHttpRequest()) {
            // On verfie le numero de la page
            // Superieur à 0, on recuper la liste
            if ($page > 0) {
                // On définit la quantité d'oiseaux
                $number = 20;
                $em = $this->getDoctrine()->getManager();


                // On calcule la taille de search,
                // Si c'est 0, search est null,
                // Sinon on lui passe la valeur sécurisé
                $search = strlen(htmlspecialchars($request->query->get('search'))) == 0 ? null : htmlspecialchars(
                    $request->query->get('search')
                );
                $couleurBec = strlen(htmlspecialchars($request->query->get('bec'))) == 0 ? null : htmlspecialchars(
                    $request->query->get('bec')
                );
                $couleurPlumage = strlen(
                    htmlspecialchars($request->query->get('plumage'))
                ) == 0 ? null : htmlspecialchars($request->query->get('plumage'));
                $couleurPatte = strlen(htmlspecialchars($request->query->get('patte'))) == 0 ? null : htmlspecialchars(
                    $request->query->get('patte')
                );
                $typeBec = strlen(htmlspecialchars($request->query->get('typeBec'))) == 0 ? null : htmlspecialchars(
                    $request->query->get('typeBec')
                );
                // On effectu la requete doctrine getPage()
                $birds = $em->getRepository('ObservationBundle:Bird')->getPage(
                    $page,
                    $number,
                    $search,
                    $couleurBec,
                    $couleurPatte,
                    $couleurPlumage,
                    $typeBec
                );

                // On calcul le nombre de page max
                $nbPage = ceil(count($birds) / $number);

                if ($nbPage < 1 && $nbPage < $page) {
                    // Si le nombre de page est inferieur à 1 ou superieur à la page, on mets tout à null
                    $birds = null;
                    $nbPage = null;
                }
            } else {
                // Sinon on passe tout à null
                $birds = null;
                $nbPage = null;
            }
            $device = $this->get('mobile_detect.mobile_detector');
            if ($device->isMobile() || $device->isTablet()) {
                return $this->render(
                    '@Observation/Bird/Mobile/page.html.twig',
                    array('birds' => $birds, 'nbPage' => $nbPage, 'page' => $page, 'number' => $number)
                );
            } else {
                return $this->render(
                    '@Observation/Bird/Desktop/page.html.twig',
                    array('birds' => $birds, 'nbPage' => $nbPage, 'page' => $page, 'number' => $number)
                );
            }
        } else {
            throw $this->createAccessDeniedException('Vous n\'avez pas le droit d\'être içi !');
        }
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     * Edition par l'admin de la fiche de l'oiseau
     */
    public function editAction(Bird $bird, Request $request)
    {
        $em = $em = $this->getDoctrine()->getManager();

        //On verifie si bird a une fiche
        //ce n'est pas le cas, premiere edition de la fiche
        if ($bird->getFiche() === null) {
            // Creation fiche et passage à l'oiseaux
            $fiche = new Fiche();
            $bird->setFiche($fiche);
            $fiche->setBird($bird);

        } //Si la fiche existe deja on la modifie
        else {
            $fiche = $bird->getFiche();
        }
        $form = $this->createForm(FicheType::class, $fiche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On persist l'oiseaux et on enregistre le tous en bdd
            $em->persist($bird);
            $em->flush();

            // Retour à la description de l'oiseau
            return $this->redirectToRoute(
                'bird_description',
                array(
                    'id' => $bird->getId(),
                )
            );
        }
        $device = $this->get('mobile_detect.mobile_detector');
        if ($device->isMobile() || $device->isTablet()) {
            return $this->render(
                '@Observation/Fiche/Mobile/editFiche.html.twig',
                array('bird' => $bird, 'form' => $form->createView())
            );
        } else {
            return $this->render(
                '@Observation/Fiche/Desktop/editFiche.html.twig',
                array('bird' => $bird, 'form' => $form->createView())
            );
        }

    }

    public function mappingAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $birds = $em->getRepository('ObservationBundle:Bird')->findAllSort();
        $device = $this->get('mobile_detect.mobile_detector');
        if ($device->isMobile() || $device->isTablet()) {
            return $this->render('@Observation/Bird/Mobile/mapping.html.twig', array('birds' => $birds));
        } else {
            return $this->render('@Observation/Bird/Desktop/mapping.html.twig', array('birds' => $birds));
        }
    }

    public function listingAction(Request $request)
    {
        $data = ['success' => true];
        if ($request->isXmlHttpRequest()) {
            try {
                $data['result'] = [];
                $em = $this->getDoctrine()->getManager();
                // S'il y a un parametre, on cible un oiseaux spéciale
                if ($request->query->get('bird') !== null) {
                    $id = (int)$request->query->get('bird');
                    $bird = $em->getRepository('ObservationBundle:Bird')->findOneBy(['id' => $id]);
                    foreach ($bird->getLocations() as $location) {
                        $data['result'][] = [
                            [
                                'lat' => $location->getLatitude(),
                                'lng' => $location->getLongitude(),
                            ],
                            [
                                'ficheUrl' => $this->generateUrl('bird_description', array('id' => $bird->getId())),
                                'addUrl' => $this->generateUrl('bird_observation', array('id' => $bird->getId())),
                                'name' => $bird->__toString(),
                                'description' => $bird->getFiche() === null ? 'Pas de description' : substr(
                                    strip_tags($bird->getFiche()->getDescription()),
                                    0,
                                    200
                                ),
                                'image' => $bird->getAvatar(
                                ) === null ? 'Pas d\'image' : '<img src="/'.$bird->getAvatar()->getWebPath(
                                    ).'" class="img-maps" alt="'.$bird->__toString().'">',
                            ],
                        ];
                    }
                } else {
                    $birds = $em->getRepository('ObservationBundle:Bird')->findAll();
                    foreach ($birds as $bird) {
                        foreach ($bird->getLocations() as $location) {
                            $data['result'][] = [
                                [
                                    'lat' => $location->getLatitude(),
                                    'lng' => $location->getLongitude(),
                                ],
                                [
                                    'ficheUrl' => $this->generateUrl('bird_description', array('id' => $bird->getId())),
                                    'addUrl' => $this->generateUrl('bird_observation', array('id' => $bird->getId())),
                                    'name' => $bird->__toString(),
                                    'description' => $bird->getFiche() === null ? 'Pas de description' : substr(
                                        strip_tags($bird->getFiche()->getDescription()),
                                        0,
                                        200
                                    ),
                                    'image' => $bird->getAvatar(
                                    ) === null ? 'Pas d\'image' : '<img src="/'.$bird->getAvatar()->getWebPath(
                                        ).'" class="img-maps" alt="'.$bird->__toString().'">',
                                ],
                            ];
                        }
                    }
                }
                // On vérifie la taille result, si elle fait 0 cela veut dire qu'il n'y a pas de location
                if (count($data['result']) === 0) {
                    $data['success'] = false;
                }
            } catch (\Exception $exception) {
                $data['success'] = false;
            }
        } else {
            $data['success'] = false;
        }
        $response = new JsonResponse($data);

        return $response;
    }
}

