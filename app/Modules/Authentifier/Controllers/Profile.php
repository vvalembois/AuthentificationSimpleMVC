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

class Profile extends Authentifier
{

    public function __construct()
    {
        parent::__construct(1);
    }
    
    
    public function routes()
    {
        Router::any('authentifier/userProfile', 'Modules\Authentifier\Controllers\Profile@userProfile');
        Router::any('authentifier/profileUpdateForm', 'Modules\Authentifier\Controllers\Profile@profileUpdateForm');
        Router::any('authentifier/profileUpdateAction', 'Modules\Authentifier\Controllers\Profile@profileUpdateAction');
    }

    public function userProfile(){
        $this->checkRequiredUserType();
        $user = ProfileModel::findByUserID(Session::get('user_id'));
        $data['user_status'] = (Session::get('user_name') ? Session::get('user_name') : "Visitor");
        View::renderTemplate('header',$data);
        $this->feedback->render();
        if($user instanceof ProfileModel){

            View::renderModule('/Authentifier/Views/Profile/user_profile', array_merge($user->getArray(), $user->getUserLastLoginTimestampArray()));
        }
        View::renderTemplate('footer');
    }
    
    public function profileUpdateForm()
    {

        $this->checkRequiredUserType();
        $data = [];
        $user = null;
        if(Login::userLoggedIn()) {
            $user = ProfileModel::findByUserID(Session::get('user_id'));
        }
        if($user instanceof ProfileModel){
            $data['user'] = $user->getArray();
        }
        $data['user_status'] = (Session::get('user_name') ? Session::get('user_name') : "Visitor");
        View::renderTemplate('header',$data);
        $this->feedback->render();
        View::renderModule('/Authentifier/Views/Profile/profile_update_form', $data);
        View::renderTemplate('footer');
    }
    
    public function profileUpdateAction()
    {
        $user_data = [];

        if(Login::userLoggedIn()) {
            $user_data['user_id'] = Session::get('user_id');

            if(Request::post('user_name') != null)
                $user_data['user_name'] = Request::post('user_name');

            if(Request::post('user_mail') != null)
                $user_data['user_email'] = Request::post('user_mail');

            if(Request::post('user_new_password')!=null)
                $user_data['user_new_password'] = Request::post('user_new_password');
            if(Request::post('user_new_password_repeat') != null)
                $user_data['user_new_password_repeat'] = Request::post('user_new_password_repeat');

            if(Request::post('user_password') != null)
                $user_data['user_password'] = Request::post('user_password');

            $user_data = InputValidation::inputsValidationProfileUpdate($user_data);

            if ($user_data)
                if($this->profileUpdateActionDatabase($user_data)) {
                    if(isset($user_data['user_new_password']))
                        $user_data['user_password'] = $user_data['user_new_password'];
                    (new Login())->loginActionDatabase($user_data['user_name'], $user_data['user_password']);
                    Url::redirect();
                }
            Url::redirect('authentifier/profileUpdateForm');
        }
    }

    /**
     * @param $user_data
     * @return bool
     */
    public function profileUpdateActionDatabase($user_data){
        // find user
        $user = LoginModel::findByUserID($user_data['user_id']);

        $update = false;

        // if user exist
        if($user instanceof LoginModel) {
            // check password
            if(!$userGoodPassword = $user->checkUserPassword($user_data['user_password'])) {
                $this->feedback->add('Wrong password',FEEDBACK_TYPE_FAIL);
            }
            if($userGoodPassword){

                // check user name is new
                if(isset($user_data['user_name']) && $user->getUserName()!=$user_data['user_name']){
                    // check if this new username isn't already use
                    if($user_name_already_exist = ProfileModel::findByUserName($user_data['user_name']) != null){
                        $this->feedback->add('Username already exist.', FEEDBACK_TYPE_WARNING);
                    }
                    else{
                        $user->setUserName($user_data['user_name']);
                        $update = true;
                    }
                }
                // check user email is new
                if(isset($user_data['user_email']) && $user->getUserEmail()!=$user_data['user_email']){
                    // check if this new username isn't already use
                    if($user_email_already_exist = ProfileModel::findByUserEMail($user_data['user_email']) != null){
                        $this->feedback->add('Username already exist.', FEEDBACK_TYPE_WARNING);
                    }
                    else{
                       $user->setUserEmail($user_data['user_email']);
                        $update = true;
                    }
                }
                //check if password is new
                if(isset($user_data['user_new_password'])){
                    if(isset($user_data['user_new_password_repeat']) && $user_data['user_new_password']==$user_data['user_new_password_repeat']){
                        $user->setUserPasswordHash(password_hash($user_data['user_new_password'], PASSWORD_DEFAULT));
                        $update = true;
                    }
                else{
                        $user_new_password_not_same = true;
                    }
                }
                if(!$user_new_password_not_same || !$user_name_already_exist || !$user_email_already_exist) {
                    if (!$update) {
                        $this->feedback->add('Nothing to update', FEEDBACK_TYPE_INFO);
                    } else {
                        $user->save();
                        $this->feedback->add('Update successful', FEEDBACK_TYPE_SUCCESS);
                        return true;
                    }
                }
            }
            else {
                $this->feedback->add('Wrong password',FEEDBACK_TYPE_FAIL);
            }

        }
        return false;
    }
}