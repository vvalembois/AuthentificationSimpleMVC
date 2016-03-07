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
        View::renderModule('/Authentifier/Views/Register/register_form', $data);
    }

    /**
     * Action effectuée à la reception d'un formulaire d'inscription
     */
    public function registerAction(){
        $user_name = strip_tags(Request::post('user_name'));
        echo "<br>".$user_name."<br>";
        $user_email = strip_tags(Request::post('user_mail'));
        echo $user_email."<br>";
        $user_email_repeat = strip_tags(Request::post('user_mail_repeat'));
        echo $user_email_repeat."<br>";
        $user_password = strip_tags(Request::post('user_password'));
        echo $user_password."<br>";
        $user_password_repeat = strip_tags(Request::post('user_password_repeat'));
        echo $user_password_repeat."<br>";
        $user_captcha = strip_tags(Request::post('user_captcha'));
        echo $user_captcha."<br>";

        echo $user_captcha."<br/>".PHP_EOL;
        $register_successful = RegisterModel::newUser($user_captcha,$user_name,$user_email,$user_email_repeat,$user_password,$user_password_repeat);
        if($register_successful){
            echo "Reussi";
        }
        else
            echo "Echec!";
    }
}