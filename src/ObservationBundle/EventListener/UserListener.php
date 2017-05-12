<?php


namespace ObservationBundle\EventListener;

use ObservationBundle\Mailer\UserMailer;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class UserListener
{
    private $encoder;
    private $mailer;

    function __construct(UserPasswordEncoder $encoder,UserMailer $mailer)
    {
        $this->encoder = $encoder;
        $this->mailer = $mailer;
    }

    public function onCreate(GenericEvent $event )
    {
        // Récuperation de l'user
        $user = $event->getSubject();
        // L'utilisateur pouvant s'incsrire avec facebook ou google, on lui attribut un password aléatoire
        if($user->getPlainPassword() == null){
            $plainPassword = uniqid();
            $user->setPlainPassword($plainPassword);
            // On envoie un mail contenant le password
            $this->mailer->connectOauth($user);

        }
        // Hash du mot de passe puis enregistrement et ajout de ROLE_OBS
        $password = $this->encoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password)
            ->addRoles('ROLE_OBS');
    }
}