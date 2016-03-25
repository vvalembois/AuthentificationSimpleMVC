<?php

namespace Modules\Authentifier\Helpers\AuthMail;

use Core\View;
use Helpers\PhpMailer\Mail;
use Modules\Authentifier\Models\UserModelTest;

/**
 * Created by PhpStorm.
 * User: equentin
 * Date: 25/03/16
 * Time: 16:29
 */
class AuthMail extends Mail
{


    public function __construct()
    {
        parent::__construct();
        new AuthMailConfig();

        $this->IsSMTP(); // enable SMTP
        $this->From = MAIL_ACCOUNT;
        $this->FromName = MAIL_SENDER;
        $this->Mailer = MAIL_METHOD;
        $this->SMTPSecure = MAIL_SMTP_SECURE;
        $this->SMTPAuth = MAIL_SMTP_AUTH;
        $this->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
        $this->Host = MAIL_SMTP_SERVER;
        $this->Port = MAIL_SMTP_PORT;
        $this->Username = MAIL_ACCOUNT;
        $this->Password = MAIL_ACCOUNT_PASSWORD;

    }

    /**
     * Envoi un mail d'activation de compte pour le nouvel utilisateur
     * @param $user
     */
    public function sendMailForActivation(UserModelTest $user){

        $text = '<h1>Activate you account</h1><p>Welcome to '.SITETITLE. $user->getUserName(). '! for visit the website, You need to visit this url for validate your account <a href="'. rand(0,100)*rand(100,1000).'">this link test</a></p>';
        $this->addAddress($user->getUserEmail());
        $this->subject('Activation compte '.$user->getUserName());
        $data = [];
        $data = array_merge($data, $user->getArray());
        $this->body(Templates\RegisterActivationMail::getTemplate($data));
        return $this->send();
    }

    /**
     * Envoi d'un mail pour la confirmation de la création de compte
     * @param $user_id
     */
    public function sendMailForConfirmation($user_id){

    }

    /**
     * Envoi d'un mail pour les mots de passes oubliés
     * @param $user_name
     */
    public function sendMailForPassword($user_name){

    }

    /**
     * Envoi d'un mail lorsqu'il y a X connexions echouée
     * @param $user_id
     */
    public function sendMailForLoginFail($user_id){

    }
}