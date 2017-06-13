<?php


namespace ObservationBundle\Mailer;


use DrewM\MailChimp\MailChimp;
use ObservationBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;

class UserMailer
{
    private $mailer;
    private $twig;

    function __construct(\Swift_Mailer $mailer, $sender, \Twig_Environment $twig, $mailchimp_key, $list_id, Session $session)
    {
        // Recuperation de Swit_mailer, de l'addresse mail de NAO, et de l'envirnoment de twig
        $this->mailer = $mailer;
        $this->sender = $sender;
        $this->twig = $twig;
        $this->mailchimp_key= $mailchimp_key;
        $this->list_id = $list_id;
        $this->session = $session;
    }

    /**
     * Methode pour envoyer un mail contenant le lien pour reformater le password
     * @param User $user
     */
    public function sendLinkPassword(User $user)
    {
        // Création du mail avec le sujet, l'expediteur et son nom, le destinataire et enfin le corps du mail qui contient la vue
        $message = \Swift_Message::newInstance()
            ->setSubject('Modification de votre mot de passe')
            ->setFrom($this->sender, 'Nos amis les oiseaux')
            ->setTo($user->getEmail())
            ->setBody(
                $this->twig->render('ObservationBundle:Email:link.password.html.twig', array('user' => $user)),
                'text/html'
            );
        // Envoie du message avec Swif_Mailer
        $this->mailer->send($message);

    }

    /**
     * Méthode lors d'une création de compte avec facebook ou google envoyant le mot de passe générer aléatoirement
     *
     * @param User $user
     */
    public function connectOAuth(User $user)
    {
        // Création du message
        $message = \Swift_Message::newInstance()
            ->setSubject('Création d\'un compte')
            ->setFrom($this->sender, 'Nos Amis les Oiseaux')
            ->setTo($user->getEmail())
            ->setBody(
                $this->twig->render('@Observation/Email/connect.oauth.html.twig', array('user' => $user)),
                'text/html'
            );
        // Envoie du message
        $this->mailer->send($message);
    }

    public function sendStatus(User $user)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($user->isEnabled() == true ? 'Reouverture de votre compte' : 'Fermeture de votre compte')
            ->setFrom($this->sender, 'Nos Amis les Oiseaux')
            ->setTo($user->getEmail())
            ->setBody(
                $this->twig->render('@Observation/Email/changing.status.user.html.twig', array('user' => $user)),
                'text/html'
            );

        if (!$this->mailer->send($message)) {
            // Il y a eu un problème donc on traite l'erreur
            throw new Exception('Le mail n\'a pas pu être envoyé');
        }
    }

    public function sendReopen(User $user)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Demande de réouverture de compte')
            ->setFrom($this->sender)
            ->setTo($user->getEmail())
            ->setBody("<p> Une demande de réactivation de votre compte viens d'être faite</p>", 'text/html');

        $this->mailer->send($message);
    }

}