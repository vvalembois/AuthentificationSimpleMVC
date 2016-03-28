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
use Modules\Authentifier\Models\UserModel;
use Modules\Authentifier\Models\UserModelTest;


class Login extends Authentifier
{

    public function routes(){
        Router::any('authentifier/loginForm', 'Modules\Authentifier\Controllers\Login@loginForm');
        Router::any('authentifier/loginAction', 'Modules\Authentifier\Controllers\Login@loginAction');
        Router::any('authentifier/logout', 'Modules\Authentifier\Controllers\Login@logout');
    }

    /**
     * Lance la page Pour le login
     */
    public function loginForm(){
        $data = [];
        View::renderTemplate('header',$data);
        $this->feedback->render();
        View::renderModule('/Authentifier/Views/Login/login_form', $data);
        View::renderTemplate('footer',$data);
    }

    /**
     * Action de login
     */
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

    /**
     * Verif des donnees lors du login
     *  @param $user_name, $user_password
     */
    public function loginActionDatabase($user_name, $user_password)
    {
        $user = null;
        if (isset($user_name) && isset($user_password)) {
            $user = LoginModel::findByUserName($user_name);

            if ($user instanceof LoginModel) {
                if ($user->getUserFailedLogins() >= 3 && ($user->getUserLastFailedLogin() > (time() - 30))) {
                    $this->feedback->add('Too many login try failed, please wait ' . (30 - (time() - $user->getUserLastFailedLogin())) . 'seconds', FEEDBACK_TYPE_FAIL);
                } else if ($user->checkUserPassword($user_password)) {
                    if ($user->checkUserActive()) {
                        $this->feedback->add('You are logged.', FEEDBACK_TYPE_SUCCESS);
                        Session::set('user_id', $user->getUserId());
                        $user->connection();
                        Url::redirect();
                    } else {
                        $this->feedback->add('You need to activate your account.', FEEDBACK_TYPE_FAIL);
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

    /**
     * Deconnection de l'utilisateur et redirection sur la page d'accueil
     */
    public function logout(){
        if($this->userLoggedIn()) {
            Session::destroy('user_id');
            Session::regenerate();
            $this->feedback->add("Vous êtes déconnecté");
        }
        Url::redirect();
    }

    /**
     * Retourne un booleen qui verifie si un utilisateur est connecte
     * @return booleen
     */
    static public function userLoggedIn(){
        return LoginModel::checkLoginSession(Session::get('user_id'),Session::id());
    }

    /**
     * Retourne toutes les informations de l'utilisateur
     * @param le nom de l'utilisateur
     * @return tableau d'information
     */
    public function userAllInfo($user_name){
        return UserModel::selectAll($user_name);
    }


    private function userProfileSetSession($user_id){
        Session::set('user_id',$user_id);
    }
}