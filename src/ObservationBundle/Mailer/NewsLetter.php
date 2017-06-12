<?php


namespace ObservationBundle\Mailer;


use DrewM\MailChimp\MailChimp;
use ObservationBundle\Entity\User;

class NewsLetter
{

    protected $mailchimp_key;
    protected $list_id;
    protected $status;

    function __construct($mailchimp_key, $list_id)
    {
        // Recuperation de l'api key de MailChimp et de la list_id

        $this->mailchimp_key= $mailchimp_key;
        $this->list_id = $list_id;
    }

    /**
     * Ajout ou mise a jour de l'emai dans la liste
     * @param User|null $user
     * @param null $email
     */
    public function addLisntingNewwsLetter(User $user = null, $email = null)
    {
        // On crée une instance de mailchimp et on hash l'email
        $MailChimp = new MailChimp($this->mailchimp_key);
        $subscriber_hash = $MailChimp->subscriberHash($user === null ? $email : $user->getEmail());
        // On verifi quelles données sont en notre pocetions
        if($user !== null){
            // Utilisation de la  fonction put qui soit mets à jour soit crée le contact
            $result = $MailChimp->put("lists/$this->list_id/members/$subscriber_hash",[
                'email_address' => $user->getEmail(),
                'merge_fields' => array(
                    'FNAME' => $user->getFirstname(),
                    'LNAME' => $user->getLastname(),
                ),
                'status' => 'subscribed'
            ]);
        }else{
            $result = $MailChimp->put("lists/$this->list_id/members/$subscriber_hash",[
                'email_address' => $email,
                'status' => 'subscribed'
            ]);
        }
        // on vérifie le status de l'envoie
        if ($MailChimp->success()){
            $this->status = true;
        }else{
            $this->status = false;
        }
    }

    /**
     * Fonction pour passer à unsubscribe l'email
     * @param $email
     * @return bool
     */
    public function removeForListing($email)
    {
        $MailChimp = new MailChimp($this->mailchimp_key);
        $subscriber_hash = $MailChimp->subscriberHash($email);
        $result = $MailChimp->patch("lists/$this->list_id/members/$subscriber_hash",[
            'status' => 'unsubscribed'
        ]);

        if ($MailChimp->success()){
            $this->status = true;
        }else{
            echo $MailChimp->getLastError();
            exit;
            $this->status = false;
        }
    }
    public function isSuccess()
    {
        return $this->status;
    }
}