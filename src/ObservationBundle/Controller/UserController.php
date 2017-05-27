<?php


namespace ObservationBundle\Controller;


use ObservationBundle\Entity\User;
use ObservationBundle\Form\User\ChangePasswordType;
use ObservationBundle\Form\User\EditUserType;
use ObservationBundle\Form\User\ResetPasswordType;
use ObservationBundle\Form\User\UsernameEmailUserType;
use ObservationBundle\Form\User\UserType;
use ObservationBundle\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


class UserController extends Controller
{
    /**
     * Action pour génerer la page permettant la connection ou l'inscription
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function connectAction(Request $request)
    {

        // Création d'un objet User et du form associé
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // On passe la requete au form et vérifie s'il est soumis et valide
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Appel d'un event dispatcher chager de hacher le mot de passe
            $this->get('event_dispatcher')->dispatch('user.register',new  GenericEvent($user));

            // Enregistrement en bdd
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // Création d'un token lié à l'user puis connection de l'user
            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->get('security.token_storage')->setToken($token);
            $this->get('session')->set('_security_main', serialize($token));


            // Enfin redirection vers la page d'accueil
            return $this->redirectToRoute('homepage');
        }

        // Récuperation du service d'authentification
        $authenticationUtils = $this->get('security.authentication_utils');

        // Récuperation des erreurs et du dernier pseudo utilisé
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        // Vérification du device et renvoie sur la vue correspondante
        $device = $this->get('mobile_detect.mobile_detector');
        if ($device->isMobile()) {
            return $this->render(
                '@Observation/User/Mobile/connect.html.twig',
                array('form' => $form->createView(), 'error' => $error, 'lastUsername' => $lastUsername)
            );
        } else {
            return $this->render(
                '@Observation/User/Desktop/connect.html.twig',
                array('form' => $form->createView(), 'error' => $error, 'lastUsername' => $lastUsername)
            );
        }
    }


    /**
     * Action de demande d'envoie de mail de reset mot de passe
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function resetAction(Request $request)
    {
        // Recuperation du form
        $form = $this->createForm(UsernameEmailUserType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            // Récuperation de l'user dont le pseudo ou l'email corresponde au form
            $user = $em->getRepository('ObservationBundle:User')->loadUserByUsername($form->getData()['username']);
            // Si le user existe et n'a pas fait de demande depuis moins de 2 heures
            $now = new \DateTime();
            if($user !== null && ($user->getToken() === null || $now->diff($user->getDateToken())->d > 2)){
                // création du token qui servira de lien
                $token = base64_encode(random_bytes(60));
                // Ajout du token et de l'heure de création
                $user->setToken($token)->setDateToken(new \DateTime());
                // Appel du service mailer et envoie du mail
                $mailer = $this->get('observation.user.mailer');
                $mailer->sendLinkPassword($user);
                // Enregistrement des modifications en bdd
                $em->flush();

            }
            //Création d'un message flash obligatoire
            $this->addFlash('success', "Nous avons pris votre demande en compte. Si votre  réponse correspond à votre profil, un email vous a été envoyer!" );
            // Retour sur la page de connection
            return $this->redirectToRoute('user_login');

        }
        // Vérification du device et renvoie vers la page correspondante
        $device = $this->get('mobile_detect.mobile_detector');
        if($device->isMobile()){
            return $this->render('ObservationBundle:User/Mobile:forgot.password.html.twig', array('form' => $form->createView()));
        }else{
            return $this->render('ObservationBundle:User/Desktop:forgot.password.html.twig', array('form' => $form->createView()));
        }
    }

    /**
     * Action de reset de mot de passe avec condition
     *
     * @param Request $request
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function resetPasswordAction(Request $request, User $user)
    {
        // L'user est récuperer grace au token, si le token n'est pas bon Symfony génere une erreur
        //Vérification de la validité de vie du token, moins de 2 h
        $now = new \DateTime();
        if($now->diff($user->getDateToken())->d > 2)
        {
            throw new \Exception('Le lien n\'est pas valide');
        }
        // Création du formulaire de reset password
        $form = $this->createForm(ResetPasswordType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            // Hash du mot de passe
            $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPlainPassword());
            // On ajoute le hash du mot de passe et on met s a null token et dateToken
            $user->setPassword($password)
                ->setToken(null)
                ->setDateToken(null);
            // On persiste le tout puis on envoye sur le form de login après avoir créer un message flash de succès
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Le mot de passe a bien été réinitialisé');

            return $this->redirectToRoute('user_login');
        }
        // Retourne la vue lié au device
        $device = $this->get('mobile_detect.mobile_detector');
        if($device->isMobile()){
            return $this->render('ObservationBundle:User/Mobile:reset.password.html.twig', array('form' => $form->createView())) ;
        }else{
            return $this->render('ObservationBundle:User/Desktop:reset.password.html.twig',array('form' => $form->createView()));
        }
    }

    /**
     * Action d'affichage et modification du profil à l'exception du mot de passe
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function profilAction(Request $request)
    {
        // Récuperation de l'user et vérification s'il est connecter
        $user = $this->getUser();
        if($user === null){
            throw new Exception('Vous n\'êtes pas autorisez!');
        }
         //Création du formulaire correspondant
        $form = $this->createForm( EditUserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            // On enregistre les modifications
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Vos données ont bien été modifiés!');
            // On renvoie sur la page profil avec un flash message
            return $this->redirectToRoute('user_profil');
        }
        // Teste du device et renvoie vers la page correspondante
        $device = $this->get('mobile_detect.mobile_detector');
        if($device->isMobile()){
            return $this->render('ObservationBundle:User/Mobile:profil.html.twig', array('form' => $form->createView()));
        }else{
            return $this->render('ObservationBundle:User/Desktop:profil.html.twig', array('form' => $form->createView()));
        }
    }

    /**
     * Action pour changer son mot de passe
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function changePasswordAction(Request $request)
    {
        $user = $this->getUser();
        if($user === null){
            throw new Exception('Vous n\'êtes pas autoriser à venir içi');
        }
        // Création du formulaire
        // Il contient un champ oldPassword qui vérifie automatiquement si c'est le bon mot de passe
        $form = $this->createForm( ChangePasswordType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            // Hash du mot de passe
            $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Votre mot de passe a bien été changé!');
            // Renvoie vers la page de profil
            return $this->redirectToRoute('user_profil');
        }
        // Teste du device et renvoie vers la page correspondante
        $device = $this->get('mobile_detect.mobile_detector');
        if($device->isMobile()){
            return $this->render('ObservationBundle:User/Mobile:change.password.html.twig', array('form' => $form->createView()));
        }else{
            return $this->render('ObservationBundle:User/Desktop:change.password.html.twig', array('form' => $form->createView()));
        }
    }

    /**
     * Action affichant la page des observation de l'utilisateur
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function myObservationsAction()
    {
        // Comme on est sur les observations de l'utilisateur all vaut false
        // all est utilisé sur les vues et les action utilisées après
        $all = 'false';
        $device = $this->get('mobile_detect.mobile_detector');
        if($device->isMobile()){
            return $this->render('@Observation/User/Mobile/list.observation.html.twig', array('all' => $all));
        }else{
            return $this->render('@Observation/User/Desktop/list.observation.html.twig', array('all' => $all));
        }
    }

    /**
     * Action affichant la page de toutes les observation
     * @Security("has_role('ROLE_NATURALISTE')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function observationsAction()
    {
        // Comme on est sur totues les observations, all vaut true
        // all est utilisé sur les vues et les action utilisées après
        $all = 'true';
        $device = $this->get('mobile_detect.mobile_detector');
        if($device->isMobile()){
            return $this->render('@Observation/User/Mobile/list.observation.html.twig', array('all' => $all));
        }else{
            return $this->render('@Observation/User/Desktop/list.observation.html.twig', array('all' => $all));
        }
    }

}