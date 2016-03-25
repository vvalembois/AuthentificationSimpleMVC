<?php

namespace Modules\Authentifier\Helpers\AuthMail;

use Helpers\PhpMailer\Mail;

/**
 * Created by PhpStorm.
 * User: equentin
 * Date: 25/03/16
 * Time: 16:29
 */
class AuthMail extends Mail
{
    /**
     * Envoi un mail d'activation de compte pour le nouvel utilisateur
     * @param $user
     */
    public static function sendMailForActivation($user){
        $mail = new Mail();
        $mail->addAddress('authentifiersmvc@gmail.com');
        $mail->subject('Activation compte');
        $mail->body("<h1>test</h1><p>Ca fonctionne !</p>");
        $mail->send();
    }

    /**
     * Envoi d'un mail pour la confirmation de la création de compte
     * @param $user_id
     */
    public static function sendMailForConfirmation($user_id){

    }

    /**
     * Envoi d'un mail pour les mots de passes oubliés
     * @param $user_name
     */
    public static function sendMailForPassword($user_name){

    }

    /**
     * Envoi d'un mail lorsqu'il y a X connexions echouée
     * @param $user_id
     */
    public static function sendMailForLoginFail($user_id){

    }
}