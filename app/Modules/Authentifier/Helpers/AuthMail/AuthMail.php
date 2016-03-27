<?php

namespace Modules\Authentifier\Helpers\AuthMail;

use Core\View;
use Helpers\PhpMailer\Mail;
use Helpers\Url;
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

        /**
         * Set the subject
         */
        $this->subject($user->getUserName().', you need to activate your account');
        /**
         * Prepare the template
         */
        $data = $user->getArray();
        $data['titlesite'] = SITETITLE;
        $data['activation_link'] = "http://".$_SERVER['HTTP_HOST'].DIR."authentifier/registerActivation?user=".$user->getUserName()."&activation=".$user->getUserActivationHash();

        $this->body($this->getTemplate('register_activation_mail', $data));

        return $this->sendTo($user->getUserEmail());
    }

    /**
     * Envoi d'un mail pour la validation d'activation de compte
     * @param $user_id
     */
    public function sendMailForValidation(UserModelTest $user){
        /**
         * Set the subject
         */
        $this->subject($user->getUserName().', your account is activated.');
        /**
         * Prepare the template
         */
        $data = $user->getArray();
        $data['titlesite'] = SITETITLE;

        $this->body($this->getTemplate('register_validation_mail', $data));

        return $this->sendTo($user->getUserEmail());
    }

    /**
     * Envoi d'un mail pour les mots de passes oubliés
     * @param $user_name
     */
    public function sendMailForPassword(UserModelTest $user){

    }

    /**
     * Envoi d'un mail lorsqu'il y a X connexions echouée
     * @param $user_id
     */
    public function sendMailForLoginFail(UserModelTest $user){
        /**
         * Set the subject
         */
        $this->subject($user->getUserName().', too many login failed.');
        /**
         * Prepare the template
         */
        $data = $user->getArray();
        $data['titlesite'] = SITETITLE;

        $this->body($this->getTemplate('login_fail_mail', $data));

        return $this->sendTo($user->getUserEmail());
    }

    /**
     * Get the body of mail with your template
     * @param $template_name
     * @param array $data
     * @return mixed|string
     */
    private function getTemplate($template_name, array $data){
        $template = file_get_contents('app/Modules/Authentifier/Helpers/AuthMail/Templates/'.$template_name.'.php');
        foreach($data as $key => $value){
            $template = preg_replace('~{{'.$key.'}}~', $value, $template);
        }
        return $template;
    }

    private function sendTo($user_email){
        // add the user's email adress as recipient
        $this->addAddress($user_email);
        return $this->send();
    }
}