<?php


namespace ObservationBundle\Mailer;


use ObservationBundle\Entity\User;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Router;

class UserMailer
{
    const MAIL = 'nao@nao.site-projet.fr';
    const NAME = 'Nos Amis les Oiseaux';
    const TEMPLATE_OAUTH = "connection-oauth";
    const TEMPLATE_RESET_PASSWORD = "link-reset-password";
    const TEMPLATE_FERMETURE_COMPTE = "fermeture-de-compte";
    const TEMPLATE_OUVERTURE_COMPTE = "r-ouverture-de-compte";
    const TEMPLATE_UNSLEEPING = "unsleeping-compte";
    protected $mandrill_api_key;
    protected $router;
    protected $result = false;

    public function __construct($mandrill_api_key, Router $router)
    {
        // Recuperation de la clé mandrill et du router
        $this->mandrill_api_key = $mandrill_api_key;
        $this->router = $router;
    }

    /**
     * Methode pour envoyer un mail contenant le lien pour reformater le password
     * @param User $user
     */
    public function sendLinkPassword(User $user)
    {
        $templateName = self::TEMPLATE_RESET_PASSWORD;
        $templateContent = [
            [
                'username' => $user->getUsername(),
                'path' => $this->router->generate('user_link_forgot', array('token' => $user->getRequestPassword()->getToken()), true)
            ]
        ];
        $sendTo = [
            [
                'email' => $user->getEmail(),
                'name' => $user->getUsername()
            ]
        ];
        $globalsMerge = [
            [
                'name' => 'username',
                'content' => $user->getUsername()
            ],
            [
                'name' => 'path',
                'content' => $this->router->generate('user_link_forgot', array('token' => $user->getRequestPassword()->getToken()), UrlGeneratorInterface::ABSOLUTE_URL)
            ]
        ];
        $this->sendMail($templateName, 'Demande de nouveau mot de passe ', $templateContent, $sendTo, $globalsMerge);

    }

    public function sendMail($templateName, $subject, $templateContent, $sendTo, $globalsMerge)
    {

        try {
            $mandrill = new \Mandrill($this->mandrill_api_key);
            $template_name = $templateName;
            $template_content =
                $templateContent;

            $message = array(
                'subject' => $subject,
                'from_mail' => 'nao@nao.site-projet.fr',
                'from_name' => 'Nos Amis les Oiseaux',
                'to' => $sendTo,
                'important' => true,
                'track_opens' => null,
                'track_clicks' => null,
                'auto_text' => null,
                'auto_html' => null,
                'inline_css' => null,
                'url_strip_qs' => null,
                'preserve_recipients' => null,
                'view_content_link' => null,
                'tracking_domain' => null,
                'signing_domain' => null,
                'return_path_domain' => null,
                'merge' => true,
                'merge_language' => 'handlebars',
                'global_merge_vars' => $globalsMerge
            );
            $result = $mandrill->messages->sendTemplate($template_name, $template_content, $message);
            $this->result = $result;
        } catch (\Mandrill_Error $e) {
            // Mandrill errors are thrown as exceptions
            echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
            // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
            throw $e;
        }
    }

    /**
     * Méthode lors d'une création de compte avec facebook ou google envoyant le mot de passe générer aléatoirement
     *
     * @param User $user
     */
    public function connectOAuth(User $user)
    {

        $templateName = self::TEMPLATE_OAUTH;
        $templateContent = [
            [
                'username' => $user->getUsername(),
                'plainPassword' => $user->getPlainPassword()
            ]
        ];
        $sendTo = [
            [
                'email' => $user->getEmail(),
                'name' => $user->getUsername()
            ]
        ];
        $globalsMerge = [
            [
                'name' => 'username',
                'content' => $user->getUsername()
            ],
            [
                'name' => 'plainPassword',
                'content' => $user->getPlainPassword()
            ]
        ];
        $this->sendMail($templateName, 'Bienvenue chez NAO', $templateContent, $sendTo, $globalsMerge);
    }

    public function sendStatus(User $user)
    {
        $templateName = $user->isEnabled() === true ? self::TEMPLATE_OUVERTURE_COMPTE : self::TEMPLATE_FERMETURE_COMPTE;
        $templateContent = [
            [
                'username' => $user->getUsername()
            ]
        ];
        $sendTo = [
            [
                'email' => $user->getEmail(),
                'name' => $user->getUsername()
            ]
        ];
        $globalsMerge = [
            [
                'name' => 'username',
                'content' => $user->getUsername()
            ]
        ];
        $this->sendMail($templateName, $user->isEnabled() === true ? 'Réouverture de votre compte' : 'Fermeture de votre compte', $templateContent, $sendTo, $globalsMerge);
    }

    public function sendReopen(User $user)
    {
        $templateName = self::TEMPLATE_UNSLEEPING;
        $templateContent = [
            [
                'username' => $user->getUsername(),
                'path' => $this->router->generate('user_unsleep', array('token' => $user->getRequestOpen()->getToken()), UrlGeneratorInterface::ABSOLUTE_URL)
            ]
        ];
        $sendTo = [
            [
                'email' => $user->getEmail(),
                'name' => $user->getUsername()
            ]
        ];
        $globalsMerge = [
            [
                'name' => 'username',
                'content' => $user->getUsername()
            ],
            [
                'name' => 'path',
                'content' => $this->router->generate('user_unsleep', array('token' => $user->getRequestOpen()->getToken()), UrlGeneratorInterface::ABSOLUTE_URL)
            ]
        ];
        $this->sendMail($templateName, 'Demande de réactivation de votre compte', $templateContent, $sendTo, $globalsMerge);
    }

    public function getResult()
    {
        return $this->result;
    }
}
