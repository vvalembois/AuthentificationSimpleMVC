<?php
/**
 * User: deloffre
 * Date: 21/02/16
 * Time: 19:48
 */


namespace Modules\Authentifier\Controllers;

use Core\Router;
use Core\View;
use Helpers\Request;
use Helpers\Session;


class Login extends Authentifier
{

    public function routes(){
        Router::any('authentifier/loginForm', 'Modules\Authentifier\Controllers\Login@loginForm');
        Router::any('authentifier/loginAction', 'Modules\Authentifier\Controllers\Login@loginAction');
        Router::any('authentifier/logout', 'Modules\Authentifier\Controllers\Login@logout');
    }

    public function loginForm(){
        $data = [];
        View::renderTemplate('header',$data);
        $this->feedback->render();
        View::renderModule('/Authentifier/Views/Login/login_form', $data);
        View::renderTemplate('footer',$data);
    }

    public function loginAction(){
        // TODO filtrage et validation des inputs
        $user_name = Request::post('user_name');
        $user_password = Request::post('user_password');

        /* Récupération du user_password_hash dans la base de donnée */
        $user_password_hash = $this->userSQL->getUserPasswordHash($user_name)[0]->user_password_hash;

        /* Vérifie si le mot de passe est bon */
        $userGoodPassword = password_verify($user_password, $user_password_hash);
        if(!$userGoodPassword)
            $this->feedback->add('Identifiant ou Mot de passe incorrect');
        else {
            $this->feedback->add('Connexion réussie!', true);
            Session::set('user_logged_in',true);
        }

        Session::set('post',$_POST);


        if(!$userGoodPassword){
            header('Location: ' . DIR . 'authentifier/loginForm');
        }
        else
            header('Location: ' . DIR);


    }

    public function logout(){
        Session::destroy();
        header('Location: /');
    }

}