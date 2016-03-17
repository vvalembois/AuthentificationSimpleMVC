<?php
/**
 * User: deloffre
 * Date: 21/02/16
 * Time: 19:49
 */

namespace Modules\Authentifier\Controllers;


use Core\Router;
use Core\View;
use Helpers\Gump;
use Helpers\RainCaptcha;
use Helpers\Request;
use Helpers\Session;
use Helpers\Url;
use Modules\Authentifier\Helpers\Feedback;
use Modules\Authentifier\Helpers\InputValidation;
use Modules\Authentifier\Models\UserModel;

class Register extends Authentifier
{


    public function __construct()
    {
        parent::__construct();
    }

    public function routes()
    {
        Router::any('authentifier/registerForm', 'Modules\Authentifier\Controllers\Register@registerForm');
        Router::any('authentifier/registerAction', 'Modules\Authentifier\Controllers\Register@registerAction');
    }

    /**
     * Formulaire d'inscription d'un nouvel utilisateur
     */
    public function registerForm()
    {
        $this->captcha = new RainCaptcha();
        $data['captcha_url'] = $this->captcha->getImage();
        $data = array_merge($data, $this->registerFormSession());
        View::renderTemplate('header');
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
            if($this->registerActionInsert($new_user_data)){
                $this->feedback->add("Well done $new_user_data[user_name], you are now registered!", FEEDBACK_TYPE_SUCCESS);
                Url::redirect();
            }
            else {
                $this->feedback->add("Registration error (database)", FEEDBACK_TYPE_FAIL);
            }
        }
        else{ // Si l'inscription a échouée, on renvoie vers le formulaire
            Session::set('post', $_POST);
            Url::redirect('authentifier/registerForm');
        }

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
            if ($usernameExist = $this->userSQL->exist($input_valids['user_name']) != null)
                $this->feedback->add("Username already exists", FEEDBACK_TYPE_WARNING);

            /* Vérification de l'inexistance de l'adresse mail dans la base de données */
            if ($mailExist = $this->userSQL->exist($input_valids['user_mail']) != null)
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
                    'user_password_hash' => password_hash($input_valids['user_password'], PASSWORD_DEFAULT) /* On crypte le mot de passe */
                );
            }
        }
        return false;
    }

    private function registerActionInsert($new_user_data){
        /* Tentative d'insertion dans la table */
        try {
            $this->userSQL->insertUser($new_user_data);
            return true;
        } catch (\Exception $e) {
            return false;

        }
    }
}