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
use Helpers\Url;


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
        if(!$userGoodPassword) {
            $this->feedback->add('Wrong username or password !', FEEDBACK_TYPE_FAIL);
            Session::set('post',$_POST);
            Url::redirect('authentifier/loginForm');
        }
        else {
            $this->feedback->add('You are logged.', FEEDBACK_TYPE_SUCCESS);
            $this->userProfileSetSession($this->userProfileInfo($user_name));
            Url::redirect();
        }


    }

    public function logout(){
        if($this->userLoggedIn()) {
            Session::destroy('user_profile_info');
            $this->feedback->add("Vous êtes déconnecté");
        }
        header('Location: /');
    }

    static public function userLoggedIn(){
        //TODO token
        return Session::get('user_profile_info')!=null;
    }

    public function userProfileInfo($user_name){
        return $this->userSQL->findByLogin($user_name);
    }

    public function userAllInfo($user_name){
        return $this->userSQL->findBy($user_name);
    }

    private function userProfileSetSession($user_name){
        Session::set('user_profile_info',$user_name);
    }
}