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
use Modules\Authentifier\Helpers\Feedback;
use Modules\Authentifier\Helpers\InputValidation;
use Modules\Authentifier\Models\UserModel;

class Register extends Authentifier
{
    private $userSQL;
    private $feedback;

    public function __construct()
    {
        parent::__construct();
        $this->userSQL = new UserModel();
        $this->feedback = new Feedback();
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
        $data['user_name'] = Session::get('post')['user_name'];
        $data['user_password'] = Session::get('post')['user_password'];
        $data['user_password_repeat'] = Session::get('post')['user_password_repeat'];
        $data['user_mail'] = Session::get('post')['user_mail'];
        $data['user_mail_repeat'] = Session::get('post')['user_mail_repeat'];
        Session::destroy('post');

        View::renderTemplate('header');
        $this->feedback->render();
        View::renderModule('/Authentifier/Views/Register/register_form', $data);
        View::renderTemplate('footer');
    }

    /**
     * Action effectuée à la reception d'un formulaire d'inscription
     */
    public function registerAction()
    {
        $this->feedback->render();
        $input_valids = InputValidation::inputsValidation($_POST);

        if (!$input_valids) {
            Session::set('post', $_POST);
            header('Location: ' . DIR . 'authentifier/registerForm');
        } else {

            /* Vérification de l'inexistance de l'utilisateur*/
            if($this->userSQL->exist($input_valids['user_name'])!=null)
                $this->feedback->add("Username already exists");

            // TODO vérification de l'inexistance de l'adresse mail

            if($this->userSQL->exist($input_valids['user_mail'])!=null){
                $this->feedback->add("Mail adress already in use");
                Session::set('post', $_POST);
            }


            /* Vérification du captcha */
            $captcha = new RainCaptcha();
            if(!$captcha_valid = $captcha->checkAnswer(Request::post('user_captcha')))
                $this->feedback->add("Captcha error");

            if($this->feedback->count()>0) {
                Session::set('post', $_POST);
                header('Location: ' . DIR . 'authentifier/registerForm');
                return;
            }
            else {
                $user_data = [
                    'user_name' => $input_valids['user_name'],
                    'user_email' => $input_valids['user_mail'],
                    'user_password_hash' => password_hash($input_valids['user_password'], PASSWORD_DEFAULT)
                ];

                try {
                    $this->userSQL->insertUser($user_data);
                } catch (\Exception $e) {
                    $this->feedback->add("Registration error (database)");
                    Session::set('post', $_POST);
                    header('Location: ' . DIR . 'authentifier/registerForm');
                }
            }
        }
    }
}