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
use Modules\Authentifier\Models\UserModelTest;


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

    public function loginActionDatabase($user_name, $user_password){
        $user = null;
        if(isset($user_name) && isset($user_password)){
            $user = LoginModel::findByUserName($user_name);

            if($user instanceof LoginModel && $user->checkUserPassword($user_password)){
                if($user->checkUserActive()){
                    $this->feedback->add('You are logged.',FEEDBACK_TYPE_SUCCESS);
                    Session::set('user_id',$user->getUserId());
                    $user->connection();
                    Url::redirect();
                }
                else
                    $this->feedback->add('You need to activate your account.', FEEDBACK_TYPE_FAIL);
            }
            else
                $this->feedback->add('Wrong username or password !',FEEDBACK_TYPE_FAIL);
        }
        Url::redirect('authentifier/loginForm');
    }

    public function logout(){
        if($this->userLoggedIn()) {
            Session::destroy('user_id');
            Session::regenerate();
            $this->feedback->add("Vous êtes déconnecté");
        }
        Url::redirect();
    }

    static public function userLoggedIn(){
        return LoginModel::checkLoginSession(Session::get('user_id'),Session::id());
    }

    public function userAllInfo($user_name){
        return UserModel::selectAll($user_name);
    }

    private function userProfileSetSession($user_id){
        Session::set('user_id',$user_id);
    }
}