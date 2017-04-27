<?php


namespace ObservationBundle\Controller;


use ObservationBundle\Entity\User;
use ObservationBundle\Form\User\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
//    private $device;
//
//    function __construct()
//    {
//        parent::__construct();
//        $this->device = $this->get('mobile_detect.mobile_detector');
//    }

    public function registrationAction(Request $request)
    {
        // Création d'un objet User et du form associé
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $device = $this->get('mobile_detect.mobile_detector');
        // On passe la requete au form et vérifie s'il est soumis et valide
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            // Hash du mot de passe en clair
            $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPlainPassword());

            $user->setPassword($password);

            // Enregistrement de l'utilisateur en bdd
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            if($device->isMobile()){

                return $this->redirectToRoute('observation_homepage');
            }
        }
        if($device->isMobile()){
            return $this->render('ObservationBundle:User:Mobile:registration.html.twig', array('form' => $form->createView()));
        }else{
            return $this->render('ObservationBundle:User:Desktop/registration.html.twig', array('form' => $form->createView()));
        }



    }

}