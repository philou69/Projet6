<?php


namespace ObservationBundle\Mailer;


use ObservationBundle\Entity\Message;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Router;

class ContactMailer
{
    protected $mandrillKey;
    protected $router;
    protected $result;

    function __construct($mandrillKey,Router $router)
    {
        $this->mandrillKey = $mandrillKey;
        $this->router = $router;
    }

    public function sendMessage(Message $message)
    {
        try{
            $mandrill = new \Mandrill($this->mandrillKey);
            $template_name = 'vous-avez-un-message';
            $template_content = [
                [
                    'name' => 'title',
                    'content' => $message->getTitle()
                ],
                [
                    'name' => 'message',
                    'content' => $message->getMessage()
                ],
                [
                    'name' => 'email',
                    'content' => $message->getEmail()
                ],
                [
                    'name' => 'path',
                    'content' => $this->router->generate('user_contacts',array(null), UrlGeneratorInterface::ABSOLUTE_URL)
                ]
            ];

            $message = array(
                'subject' => 'Un message vient d\'être déposer',
                'from_mail' => 'nao@nao.site-projet.fr',
                'from_name' => 'Nos Amis les Oiseaux',
                'to' => [
                    [
                        'email' => 'admin@nao.site-projet.fr',
                        'name' => 'Administrateur'
                    ]
                ],
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
                'global_merge_vars' => [
                    [
                        'name' => 'title',
                        'content' => $message->getTitle()
                    ],
                    [
                        'name' => 'message',
                        'content' => $message->getMessage()
                    ],
                    [
                        'name' => 'email',
                        'content' => $message->getEmail()
                    ],
                    [
                        'name' => 'path',
                        'content' => $this->router->generate('user_contacts',array(null), UrlGeneratorInterface::ABSOLUTE_URL)
                    ]
                ]
            );
            $result = $mandrill->messages->sendTemplate($template_name, $template_content, $message);
            $this->result = $result;
        } catch(\Mandrill_Error $e) {
            // Mandrill errors are thrown as exceptions
            echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
            // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
            throw $e;
        }
    }
}