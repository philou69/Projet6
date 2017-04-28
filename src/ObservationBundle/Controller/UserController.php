<?php


namespace ObservationBundle\Controller;


use ObservationBundle\Entity\User;
use ObservationBundle\Form\User\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

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
        if ($form->isSubmitted() && $form->isValid()) {
            // Hash du mot de passe en clair
            $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPlainPassword());

            $user->setPassword($password);
            $user->addRoles('ROLE_OBS');
            // Enregistrement de l'utilisateur en bdd
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // Création d'un token lié à l'user puis connection de l'user
            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->get('security.token_storage')->setToken($token);
            $this->get('session')->set('_security_main', serialize($token));

            return $this->redirectToRoute('observation_homepage');
        }
        // Vérification du device et renvoie sur la vue correspondante
        if ($device->isMobile()) {
            return $this->render(
                'ObservationBundle:User:Mobile/registration.html.twig',
                array('form' => $form->createView())
            );
        } else {
            return $this->render(
                'ObservationBundle:User:Desktop/registration.html.twig',
                array('form' => $form->createView())
            );
        }


    }

    public function loginAction(Request $request)
    {
        // Récuperation du service d'authentification
        $authenticationUtils = $this->get('security.authentication_utils');
        // Récuperation des erreurs et du dernier pseudo utilisé
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        $device = $this->get('mobile_detect.mobile_detector');

        if($device->isMobile()){
            return $this->render('ObservationBundle:User/Mobile:login.html.twig', array('error' => $error, 'lastUsername' => $lastUsername));
        }else{
            return $this->render('ObservationBundle:User/Desktop:login.html.twig', array('error' => $error, 'lastUsername' => $lastUsername));
        }
    }

    public function profilAction(Request $request)
    {

    }

}