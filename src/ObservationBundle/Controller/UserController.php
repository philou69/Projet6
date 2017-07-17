<?php


namespace ObservationBundle\Controller;


use ObservationBundle\Entity\RequestOpen;
use ObservationBundle\Entity\RequestPassword;
use ObservationBundle\Entity\User;
use ObservationBundle\Event\UserEvent;
use ObservationBundle\Form\Type\User\ChangeAvartarType;
use ObservationBundle\Form\Type\User\ChangePasswordType;
use ObservationBundle\Form\Type\User\EditUserType;
use ObservationBundle\Form\Type\User\ResetPasswordType;
use ObservationBundle\Form\Type\User\RolesType;
use ObservationBundle\Form\Type\User\UsernameEmailUserType;
use ObservationBundle\Form\Type\User\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
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
        if($this->getUser()){
            return $this->redirectToRoute('user_profil');
        }
        // Création d'un objet User et du form associé
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // On passe la requete au form et vérifie s'il est soumis et valide
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Appel d'un event dispatcher chager de hacher le mot de passe
            $this->get('event_dispatcher')->dispatch('user.register', new  GenericEvent($user));

            // Enregistrement en bdd
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // Création d'un token lié à l'user puis connection de l'user
            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->get('security.token_storage')->setToken($token);
            $this->get('session')->set('_security_main', serialize($token));

            $this->get('event_dispatcher')->dispatch('user.captured', new UserEvent($user));

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
        if ($device->isMobile() || $device->isTablet()) {
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
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            // Récuperation de l'user dont le pseudo ou l'email corresponde au form
            $user = $em->getRepository('ObservationBundle:User')->loadUserByUsername($form->getData()['username']);
            $now = new \DateTime();
            // Si le user existe
            if ($user !== null) {
                // création du token qui servira de lien
                $token = str_replace(['/', '+', '*','-'], '', base64_encode(random_bytes(60)));
                // Appel du service mailer
                $mailer = $this->get('observation.user.mailer');
                // Le visiteur a dèjà fait une demande de renouvellement de mot de passe et il y a plus de 2 heures
                if ($user->getRequestPassword() !== null && $now->diff($user->getRequestPassword()->getWhenToken())->h >= 2) {
                    // le visiteur à fait une demande il y a plus de deux heures
                    $user->getRequestPassword()->setToken($token)->setWhenToken($now)->setAddressIP($request->getClientIp());
                    $mailer->sendLinkPassword($user);
                } elseif ($user->getRequestPassword() === null) {
                    // Le visiteur n'a jamais fait de demande
                    $requestPassword = new RequestPassword();
                    $requestPassword->setUser($user)->setToken($token)->setWhenToken($now)->setAddressIP(
                        $request->getClientIp()
                    );
                    $user->setRequestPassword($requestPassword);
                    $mailer->sendLinkPassword($user);
                };

                // Enregistrement des modifications en bdd
                $em->flush();

            }
            //Création d'un message flash obligatoire
            $this->addFlash(
                'success',
                "Nous avons pris votre demande en compte. Si votre  réponse correspond à votre profil, un email vous a été envoyer!"
            );

            // Retour sur la page de connection
            return $this->redirectToRoute('user_connect');

        }
        // Vérification du device et renvoie vers la page correspondante
        $device = $this->get('mobile_detect.mobile_detector');
        if ($device->isMobile() || $device->isTablet()) {
            return $this->render(
                'ObservationBundle:User/Mobile:forgot.password.html.twig',
                array('form' => $form->createView())
            );
        } else {
            return $this->render(
                'ObservationBundle:User/Desktop:forgot.password.html.twig',
                array('form' => $form->createView())
            );
        }
    }

    /**
     * Action de reset de mot de passe après une demande
     *
     * @param Request $request
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function resetPasswordAction(Request $request, RequestPassword $requestPassword)
    {
        // L'user est récuperer grace au token, si le token n'est pas bon Symfony génere une erreur
        //Vérification de la validité de vie du token, moins de 2 h, que l'adresse ip corresponde et que le token n'a pas été utilisé depuis
        $now = new \DateTime();
        $user = $requestPassword->getUser();
        if ($now->diff($user->getRequestPassword()->getWhenToken())->h >= 2 || $user->getRequestPassword()->getAddressIP() != $request->getClientIp() || $user->getRequestPassword()->isUsed()) {
            throw new \Exception('Le lien n\'est pas valide');
        }
        // Création du formulaire de reset password
        $form = $this->createForm(ResetPasswordType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            // Hash du mot de passe
            $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPlainPassword());
            // On ajoute le hash du mot de passe et on passe used à true
            $user->setPassword($password)
                ->getRequestPassword()->setUsed(true);
            // On persiste le tout puis on envoye sur le form de login après avoir créer un message flash de succès
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Le mot de passe a bien été réinitialisé');

            return $this->redirectToRoute('user_connect');
        }
        // Retourne la vue lié au device
        $device = $this->get('mobile_detect.mobile_detector');
        if ($device->isMobile() || $device->isTablet()) {
            return $this->render(
                'ObservationBundle:User/Mobile:reset.password.html.twig',
                array('form' => $form->createView())
            );
        } else {
            return $this->render(
                'ObservationBundle:User/Desktop:reset.password.html.twig',
                array('form' => $form->createView())
            );
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
        $oldUser = clone $user;
        //Création du formulaire correspondant
        $form = $this->createForm(EditUserType::class, $user);
        $formPassword = $this->createForm(
            ChangePasswordType::class,
            $user,
            array('action' => $this->generateUrl('user_change_password'))
        );
        $formPassword->handleRequest($request);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // On enregistre les modifications
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->get('event_dispatcher')->dispatch('user.captured', new  UserEvent($user));

            $this->addFlash('success', 'Vos données ont bien été modifiés!');
            $mailer = $this->get('observation.newsletter_listing');
            // On vérifie si l'utilisateur viens d'activer les newsletters
            if ($user->getNewsletter() && !$oldUser->getNewsletter()) {
                $mailer->addLisntingNewwsLetter($user);
            } elseif (!$user->getNewsLetter() && $oldUser->getNewsLetter()) {
                $mailer->removeForListing($user->getEmail());
            }

            // On renvoie sur la page profil avec un flash message
            return $this->redirectToRoute('user_profil');
        }
        // Teste du device et renvoie vers la page correspondante
        $device = $this->get('mobile_detect.mobile_detector');
        if ($device->isMobile() || $device->isTablet()) {
            return $this->render(
                'ObservationBundle:User/Mobile:profil.html.twig',
                array('form' => $form->createView(), 'formPassword' => $formPassword->createView())
            );
        } else {
            return $this->render(
                'ObservationBundle:User/Desktop:profil.html.twig',
                array('form' => $form->createView(), 'formPassword' => $formPassword->createView())
            );
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
        if ($user === null) {
            throw new Exception('Vous n\'êtes pas autoriser à venir içi');
        }
        // Création du formulaire
        // Il contient un champ oldPassword qui vérifie automatiquement si c'est le bon mot de passe
        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
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
        if ($device->isMobile() || $device->isTablet()) {
            return $this->render(
                'ObservationBundle:User/Mobile:change.password.html.twig',
                array('form' => $form->createView())
            );
        } else {
            return $this->render(
                'ObservationBundle:User/Desktop:change.password.html.twig',
                array('form' => $form->createView())
            );
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
        if ($device->isMobile() || $device->isTablet()) {
            return $this->render('@Observation/User/Mobile/list.observation.html.twig', array('all' => $all));
        } else {
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
        if ($device->isMobile() || $device->isTablet()) {
            return $this->render('@Observation/User/Mobile/list.observation.html.twig', array('all' => $all));
        } else {
            return $this->render('@Observation/User/Desktop/list.observation.html.twig', array('all' => $all));
        }
    }

    public function starsAction()
    {
        // L'accès n'étant pas autorisé aux naturaliste, on soulève un AccessDenied
        if ($this->getUser()->hasRole('ROLE_NATURALISTE')) {
            throw $this->createAccessDeniedException("Vous n'avez pas les droits d'accès!");
        }

        // Autrement, on renvoie sans se soucier de l'appareil
        return $this->render('@Observation/User/list.stars.html.twig');

    }

    public function changeAvatarAction(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangeAvartarType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($user);
            $em->flush();

            $this->get('event_dispatcher')->dispatch('user.captured', new  UserEvent($user));

            return $this->redirectToRoute('user_profil');
        }

        $device = $this->get('mobile_detect.mobile_detector');

        if ($device->isMobile() || $device->isTablet()) {
            return $this->render(
                '@Observation/User/Mobile/change.avatar.html.twig',
                array('form' => $form->createView())
            );
        } else {
            return $this->render(
                '@Observation/User/Desktop/change.avatar.html.twig',
                array('form' => $form->createView())
            );
        }
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function usersAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('ObservationBundle:User')->findAllOthers($this->getUser()->getId());

        $device = $this->get('mobile_detect.mobile_detector');

        if ($device->isMobile() || $device->isTablet()) {
            return $this->render('@Observation/User/Mobile/list.users.html.twig', array('users' => $users));
        } else {
            return $this->render('@Observation/User/Desktop/list.users.html.twig', array('users' => $users));
        }
    }

    public function reactivateAction(User $user)
    {
        $user->setActive($user->getActive() === true ? false : true);
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        $this->get('observation.user.mailer')->sendStatus($user);

        return $this->redirectToRoute('user_users');
    }

    public function sleepAction()
    {
        $user = $this->getUser();
        $user->setSleeping(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('user_logout');
    }

    public function unsleepAction(RequestOpen $requestOpen, Request $request)
    {
        $user= $requestOpen->getUser();
        $user->setSleeping(false);
        $user->setRequestOpen(null);

        $em = $this->getDoctrine()->getManager();

        $em->persist($user);
        $em->remove($requestOpen);
        $em->flush();
        $this->addFlash('info', 'Votre compte viens d\'être réactiver');

        return $this->redirectToRoute('user_connect');
    }

    public function rolesAction(User $user, Request $request)
    {
        $form = $this->createForm(RolesType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Les roles du visiteur ont été modifier avec succès!');
            return $this->redirectToRoute('user_users');
        }
        $device = $this->get('mobile_detect.mobile_detector');
        if ($device->isMobile() || $device->isTablet()) {
            return $this->render('@Observation/User/Mobile/managed.roles.html.twig', array('form' => $form->createView()));
        } else {
            return $this->render('@Observation/User/Desktop/managed.roles.html.twig', array('form' => $form->createView()));
        }
    }

    public function contactsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $messages = $em->getRepository('ObservationBundle:Message')->findAllOrdering();

        $device = $this->get('mobile_detect.mobile_detector');
        if ($device->isMobile() || $device->isTablet()) {
            return $this->render('ObservationBundle:User/Mobile:list.contacts.html.twig', array('messages' => $messages));
        } else {
            return $this->render('ObservationBundle:User/Desktop:list.contacts.html.twig', array('messages' => $messages));
        }

    }

    public function loginAction()
    {

    }
}
