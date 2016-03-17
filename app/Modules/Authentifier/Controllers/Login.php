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
use Modules\Authentifier\Helpers\InputValidation;
use Modules\Authentifier\Models\LoginModel;
use Modules\Authentifier\Models\UserModel;


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
        // Get user inputs
        $user_data['user_name'] = Request::post('user_name');
        $user_data['user_password'] =Request::post('user_password');

        // Check and filter user inputs
        $user_data = InputValidation::inputsValidationLogin($user_data);

        // If user inputs validated
        if($user_data)
            $this->loginActionDatabase($user_data['user_name'], $user_data['user_password']);
        else
            Url::redirect('authentifier/loginForm');
    }

    public function loginActionDatabase($user_name = false, $user_password = false){

        // Get the user_id
        $user_id = UserModel::selectID($user_name);

        // Check the user password
        $user_check_password = false;
        if($user_id) {
            $user_check_password = LoginModel::checkPassword($user_password, $user_id);
        }

        // Login successful
        if($user_check_password) {
            $this->feedback->add('You are logged.', FEEDBACK_TYPE_SUCCESS);
            $this->userProfileSetSession($user_id);
            Url::redirect();
        }
        else { // Login failed
            $this->feedback->add('Wrong username or password !', FEEDBACK_TYPE_FAIL);
            Session::set('post',Request::post(''));
            Url::redirect('authentifier/loginForm');
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
        return Session::get('user_id')!=null;
    }

    public function userAllInfo($user_name){
        return UserModel::selectAll($user_name);
    }

    private function userProfileSetSession($user_id){
        Session::set('user_id',$user_id);
    }
}