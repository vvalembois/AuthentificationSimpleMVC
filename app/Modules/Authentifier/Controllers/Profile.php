<?php
/**
 * User: deloffre
 * Date: 21/02/16
 * Time: 19:50
 */

namespace Modules\Authentifier\Controllers;

use Core\Router;
use Core\View;
use Helpers\Request;
use Helpers\Session;
use Helpers\Url;
use Modules\Authentifier\Helpers\InputValidation;
use Modules\Authentifier\Models\LoginModel;
use Modules\Authentifier\Models\ProfileModel;
use Modules\Authentifier\Models\UserModel;
use Modules\Authentifier\Models\UserModelTest;

class Profile extends Authentifier
{

    public function __construct()
    {
        parent::__construct();
    }
    
    
    public function routes()
    {
        Router::any('authentifier/profileUpdateForm', 'Modules\Authentifier\Controllers\Profile@profileUpdateForm');
        Router::any('authentifier/profileUpdateAction', 'Modules\Authentifier\Controllers\Profile@profileUpdateAction');
    }
    
    public function profileUpdateForm()
    {
        $data = [];
        if($this->userData != null){
            $data['user'] = ProfileModel::selectProfile(Session::get('user_id'));
        }
        View::renderTemplate('header');
        $this->feedback->render();
        View::renderModule('/Authentifier/Views/Profile/profile_update_form', $data);
        View::renderTemplate('footer');
    }
    
    public function profileUpdateAction()
    {
        $user_data = [];

        if(Login::userLoggedIn()) {
            $user_data['user_id'] = Session::get('user_id');
            $user_data['user_name'] = Request::post('user_name');
            $user_data['user_email'] = Request::post('user_mail');
            $user_data['user_new_password'] = Request::post('user_new_password');
            $user_data['user_new_password_repeat'] = Request::post('user_new_password_repeat');
            $user_data['user_password'] = Request::post('user_password');

            $user_data = InputValidation::inputsValidationProfileUpdate($user_data);

            if ($user_data)
                if($this->profileUpdateActionDatabase($user_data)) {
                    Url::redirect();
                }
                else {
                    Url::redirect('authentifier/updateForm');
                }
        }
    }

    public function profileUpdateActionDatabase($user_data){
        // check password
        if(!$userGoodPassword = UserModelTest::findByUserID($user_data['user_id'], $user_data['user_password'])){
            $this->feedback->add('Wrong password',FEEDBACK_TYPE_FAIL);
        }
        else {
            // check user name available
            if ($this->userData['user_name'] != $user_data['user_name'] && $user_name_exist = UserModel::exist($user_data['user_name']))
                $this->feedback->add('Username already exist.', FEEDBACK_TYPE_WARNING);

            // check user email available
            if ($this->userData['user_email'] != $user_data['user_email'] && $user_mail_exist = UserModel::exist($user_data['user_email']))
                $this->feedback->add('Mail adress already exist.', FEEDBACK_TYPE_WARNING);
        }

        $user_data_update = [];
        // If all user data are ok
        if(!$user_name_exist && !$user_mail_exist && $userGoodPassword){
            if($this->userData['user_name'] != $user_data['user_name'])
                $user_data_update['user_name'] = $user_data['user_name'];
            if($this->userData['user_email'] != $user_data['user_email'])
                $user_data_update['user_email'] = $user_data['user_email'];
            $newPassword = $user_data['user_new_password'];

            if(!isset($newPassword)){
                $user_data_update['user_password_hash'] = password_hash($newPassword,PASSWORD_DEFAULT);

            }
            if(empty($user_data_update)) {
                $this->feedback->add('No changes to update', FEEDBACK_TYPE_INFO);
                return false;
            }
            else{
                ProfileModel::updateUserProfile($user_data_update, $this->userData);
                $this->feedback->add('Account update succefull', FEEDBACK_TYPE_SUCCESS);
                //TODO si la connexion est un succes, il faut connecter l'utilisateur
            }

            return true;
        }

        return false;
    }
}