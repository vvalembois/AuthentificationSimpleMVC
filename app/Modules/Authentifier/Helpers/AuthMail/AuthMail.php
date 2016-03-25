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
        $this->From = MAIL_ACCOUNT;
        $this->Mailer = smtp;
        $this->Host = MAIL_SMTP_SERVER;
        $this->Password = MAIL_ACCOUNT_PASSWORD;
    }

    /**
     * Envoi un mail d'activation de compte pour le nouvel utilisateur
     * @param $user
     */
    public function sendMailForActivation($user){
        $mail = new Mail();
        $mail->addAddress(UserModelTest::findByUserEMail($user));
        $mail->subject('Activation compte');
        $mail->body('<h1>test</h1>');
        $mail->send();
        echo "Send";
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