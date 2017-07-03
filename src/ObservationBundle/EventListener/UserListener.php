<?php


namespace ObservationBundle\EventListener;

use ObservationBundle\Mailer\NewsLetter;
use ObservationBundle\Mailer\UserMailer;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class UserListener
{
    protected $newsletter;
    private $encoder;
    private $mailer;

    public function __construct(UserPasswordEncoder $encoder, UserMailer $mailer, NewsLetter $newsletter)
    {
        $this->encoder = $encoder;
        $this->mailer = $mailer;
        $this->newsletter = $newsletter;
    }

    public function onCreate(GenericEvent $event )
    {
        // Récuperation de l'user
        $user = $event->getSubject();
        // L'utilisateur pouvant s'incsrire avec facebook ou google, on lui attribut un password aléatoire
        if ($user->getPlainPassword() === null) {
            $plainPassword = uniqid();
            $user->setPlainPassword($plainPassword);
            // On envoie un mail contenant le password
            $this->mailer->connectOauth($user);

        }
        // Hash du mot de passe puis enregistrement et ajout de ROLE_OBS
        $password = $this->encoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password)
            ->addRole('ROLE_OBS');
        if($user->getNewsletter()){
            $this->newsletter->addLisntingNewwsLetter($user, null);
        }
    }
    public function reOpen(GenericEvent $event)
    {
        $user = $event->getSubject();
        $this->mailer->sendReopen($user);
    }

}
