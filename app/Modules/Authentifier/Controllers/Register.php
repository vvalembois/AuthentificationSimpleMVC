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
use Modules\Authentifier\Helpers\InputValidation;
use Modules\Authentifier\Models\RegisterModel;

class Register extends Authentifier
{
    public function routes(){
        Router::any('authentifier/registerForm', 'Modules\Authentifier\Controllers\Register@registerForm');
        Router::any('authentifier/registerAction', 'Modules\Authentifier\Controllers\Register@registerAction');
    }

    /**
     * Formulaire d'inscription d'un nouvel utilisateur
     */
    public function registerForm(){
        $this->captcha = new RainCaptcha();
        $data['captcha_url'] = $this->captcha->getImage();

        View::renderTemplate('header');
        View::renderModule('/Authentifier/Views/Register/register_form', $data);
        View::renderTemplate('footer');
    }

    /**
     * Action effectuée à la reception d'un formulaire d'inscription
     */
    public function registerAction(){
        $input_valids = InputValidation::inputsValidation($_POST);
        //$register_successful = RegisterModel::newUser($user_captcha,$user_name,$user_email,$user_email_repeat,$user_password,$user_password_repeat);
        //if($register_successful){

        if($input_valids){
            echo "<br>Inputs : ".($input_valids? réussite : echec);
            $captcha = new RainCaptcha();
            $captcha_valid = $captcha->checkAnswer(Gump::xss_clean([Request::post('user_captcha')]));
            echo "<br>Captcha : ".($captcha_valid? réussite : echec);
        }


    }
}