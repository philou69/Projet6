<?php


namespace ObservationBundle\Mailer;


use ObservationBundle\Entity\User;

class UserMailer
{
    private $mailer;
    private $twig;

    function __construct(\Swift_Mailer  $mailer, $sender, \Twig_Environment $twig)
    {
        // Recuperation de Swit_mailer, de l'addresse mail de NAO, et de l'envirnoment de twig
        $this->mailer = $mailer;
        $this->sender = $sender;
        $this->twig = $twig;
    }

    public function sendLinkPassword(User $user)
    {
         // Création du mail avec le sujet, l'expediteur et son nom, le destinataire et enfin le corps du mail qui contient la vue
        $message = \Swift_Message::newInstance()
            ->setSubject('Modification de votre mot de passe')
            ->setFrom($this->sender, 'Nos amis les oiseaux')
            ->setTo($user->getEmail())
            ->setBody($this->twig->render('ObservationBundle:Email:link.password.html.twig', array('user' => $user)),'text/html');
        // Envoie du message avec Swif_Mailer
        $this->mailer->send($message);
    }
}