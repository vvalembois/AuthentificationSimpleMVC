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
use Modules\Authentifier\Helpers\AuthMail\AuthMail;
use Modules\Authentifier\Helpers\InputValidation;
use Modules\Authentifier\Models\LoginModel;

class Login extends Authentifier
{

    public function routes(){
        Router::any('authentifier/loginForm', 'Modules\Authentifier\Controllers\Login@loginForm');
        Router::post('authentifier/loginAction', 'Modules\Authentifier\Controllers\Login@loginAction');
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
        $user_data['remember_me'] = Request::post('remember_me');

        // Check and filter user inputs
        $user_data = InputValidation::inputsValidationLogin($user_data);

        // If user inputs validated
        if($user_data)
            $this->loginActionDatabase($user_data['user_name'], $user_data['user_password'], $user_data['remember_me']);
        else
            Url::redirect('authentifier/loginForm');
    }

    public function loginActionDatabase($user_name, $user_password, $remember_cookie = false)
    {
        $user = null;
        if (isset($user_name) && isset($user_password)) {
            $user = LoginModel::findByUserName($user_name);

            if ($user instanceof LoginModel) {
                if ($user->getUserFailedLogins() >= 3 && ($user->getUserLastFailedLogin() > (time() - 30))) {
                    $this->feedback->add('You had too many failed login, wait ' . (30 - (time() - $user->getUserLastFailedLogin())) . ' seconds.', FEEDBACK_TYPE_FAIL);
                } else if ($user->checkUserPassword($user_password)) {
                    if ($user->checkUserActive()) {
                        $user->connection($remember_cookie);
                        $this->feedback->add('You are now logged as '.$user->getUserName().'.', FEEDBACK_TYPE_SUCCESS);
                        Url::redirect();
                    } else {
                        $this->feedback->add('You need to activate your account with the email you received at '.$user->getUserEmail(), FEEDBACK_TYPE_FAIL);
                    }
                } else {
                    $this->feedback->add('Wrong username or password !', FEEDBACK_TYPE_FAIL);
                    $user->loginFailed();
                    if($user->getUserFailedLogins() >= 3){
                        $mail = new AuthMail();
                        $mail->sendMailForLoginFail($user);
                    }
                }
            }
            else{
                $this->feedback->add('Wrong username or password !', FEEDBACK_TYPE_FAIL);
            }
        }


        Url::redirect('authentifier/loginForm');
    }

    public function logout(){
            $user = LoginModel::findBySession();
            if($user instanceof LoginModel) {
                $user->logout();
                $this->feedback->add("You're now logout.");
            }
        Url::redirect();
    }

    static public function userLoggedIn(){
        return LoginModel::userIsLoggedIn();
    }

    private function userProfileSetSession($user_id){
        Session::set('user_id',$user_id);
    }
}