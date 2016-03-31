<?php
/**
 * User: deloffre
 * Date: 21/02/16
 * Time: 19:49
 */

namespace Modules\Authentifier\Controllers;


use Core\Router;
use Core\View;
use Helpers\RainCaptcha;
use Helpers\Request;
use Helpers\Session;
use Helpers\Url;
use Modules\Authentifier\Helpers\AuthMail\AuthMail;
use Modules\Authentifier\Helpers\Feedback;
use Modules\Authentifier\Helpers\InputValidation;
use Modules\Authentifier\Models\ProfileModel;
use Modules\Authentifier\Models\RegisterModel;
use Modules\Authentifier\Models\UserModel;

class Register extends Authentifier
{
    private $mail;

    public function __construct()
    {
        parent::__construct();
        $this->mail = new AuthMail();
    }

    public function routes()
    {
        Router::any('authentifier/registerForm', 'Modules\Authentifier\Controllers\Register@registerForm');
        Router::any('authentifier/registerAction', 'Modules\Authentifier\Controllers\Register@registerAction');
        Router::any('authentifier/registerActivation', 'Modules\Authentifier\Controllers\Register@registerActivation');
    }

    /**
     * Formulaire d'inscription d'un nouvel utilisateur
     */
    public function registerForm()
    {
        $this->captcha = new RainCaptcha();
        $data['captcha_url'] = $this->captcha->getImage();
        $data = array_merge($data, $this->registerFormSession());
        $data['user_status'] = (Session::get('user_name') ? Session::get('user_name') : "Visitor");
        View::renderTemplate('header',$data);
        $this->feedback->render();
        View::renderModule('/Authentifier/Views/Register/register_form', $data);
        View::renderTemplate('footer');
    }


    /**
     * Action effectuée à la réception d'un formulaire d'inscription
     */
    public function registerAction($new_user_data = false)
    {
        if(!$new_user_data) {
            $this->registerFormPost();
        }
        if ($new_user_data = $this->registerFormDataValidation($new_user_data)) {

            /* Tentative d'insertion dans la table */
            $user = $this->registerActionInsert($new_user_data);
            if($user instanceof UserModel){
                $this->mail->sendMailForActivation($user);
                $this->feedback->add("Well done $new_user_data[user_name], you are now registered!", FEEDBACK_TYPE_SUCCESS);
                $this->feedback->add("You need to activate your account, activation link has been sent to you by email to ".$new_user_data['user_email'].".", FEEDBACK_TYPE_INFO);
                Url::redirect();
            }
            else {
                $this->feedback->add("Registration error (database)", FEEDBACK_TYPE_FAIL);
            }
        }
        // Si l'inscription a échouée, on renvoie vers le formulaire
        Session::set('post', $_POST);
        Url::redirect('authentifier/registerForm');
    }

    public function registerActivation(){
        $user_name = Request::get('user');
        $user_activation_hash = Request::get('activation');
        $user = RegisterModel::findByUserName($user_name);

        if($user instanceof RegisterModel && $user->setUserActiveValidate($user_activation_hash)) {
            $this->mail->sendMailForValidation($user);
            $this->feedback->add($user->getUserName() . ', your account is now activated!', FEEDBACK_TYPE_SUCCESS);
        }
        else
                $this->feedback->add('Activation failed', FEEDBACK_TYPE_FAIL);
        Url::redirect();
    }

    private function registerFormSession(){
        return array(
            'user_name' => Session::get('post')['user_name'],
            'user_password' => Session::get('post')['user_password'],
            'user_password_repeat' => Session::get('post')['user_password_repeat'],
            'user_mail' => Session::get('post')['user_mail'],
            'user_mail_repeat' => Session::get('post')['user_mail_repeat']
        );
    }

    private function registerFormPost(){
        return array(
            'user_name' => Request::post('user_name'),
            'user_password' => Request::post('user_password'),
            'user_password_repeat' => Request::post('user_password_repeat'),
            'user_mail' => Request::post('user_mail'),
            'user_mail_repeat' => Request::post('user_mail_repeat')
        );
    }

    private function registerFormDataValidation($register_form_data){
        $input_valids = InputValidation::inputsValidationRegister($this->registerFormPost());

        if ($input_valids) {
            /* Vérification de l'inexistance du nom d'utilisateur dans la base de données */
            if ($usernameExist = ProfileModel::findByUserName($input_valids['user_name']) != null)
                $this->feedback->add("Username already exists", FEEDBACK_TYPE_WARNING);

            /* Vérification de l'inexistance de l'adresse mail dans la base de données */
            if ($mailExist = ProfileModel::findByUserEMail($input_valids['user_mail']) != null)
                $this->feedback->add("Mail adress already in use", FEEDBACK_TYPE_WARNING);

            /* Vérification du captcha */
            $captcha = new RainCaptcha();
            if (!$captcha_valid = $captcha->checkAnswer(Request::post('user_captcha')))
                $this->feedback->add("Wrong captcha", FEEDBACK_TYPE_FAIL);

            /* Si tout est validé, alors on ajoute à la base de donnée */
            if (!$usernameExist && !$mailExist && $captcha_valid) {

                /* On récupère un tableau avec les paramètres à utiliser */
                return array(
                    'user_name' => $input_valids['user_name'],
                    'user_email' => $input_valids['user_mail'],
                    'user_password_hash' => password_hash($input_valids['user_password'], PASSWORD_DEFAULT), /* On crypte le mot de passe */
                    'user_activation_hash' =>  sha1(uniqid(mt_rand(), true))
                );
            }
        }
        return false;
    }

    private function registerActionInsert($new_user_data){
        $new_user = new RegisterModel();
        $new_user->setUserName($new_user_data['user_name']);
        $new_user->setUserEmail($new_user_data['user_email']);
        $new_user->setUserPasswordHash($new_user_data['user_password_hash']);
        $new_user->setUserActivationHash($new_user_data['user_activation_hash']);
        $new_user->setUserAccountType(1);
        $new_user->setUserActive(0);
        $new_user->setUserDeleted(0);
        $new_user->setUserFailedLogins(0);
        $new_user->setUserHasAvatar(0);
        /* Tentative d'insertion dans la table */
        if($new_user->save())
            return $new_user;
        else
            return null;
    }
}