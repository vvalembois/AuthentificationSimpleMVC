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
        if($this->userData != null){
            $data['user'] = $this->getUserInfo();
        }
       
        View::renderTemplate('header');
        $this->feedback->render();
        View::renderModule('/Authentifier/Views/Profile/profile_update_form', $data);
        View::renderTemplate('footer');
    }
    
    public function profileUpdateAction()
    {
        if($newUserName = Request::post('user_name'))
            $update['user_name'] = $newUserName;
        if($newMailAdress = Request::post('user_mail'))
            $update['user_email'] = $newMailAdress;
        if($newPassword = Request::post('user_new_password'))
            $update['user_new_password'] = $newPassword;
        if($newPasswordRepeat = Request::post('user_new_password_repeat'))
            $update['user_new_password_repeat'] = $newPasswordRepeat;
        if($oldPassword = Request::post('user_password'))
            $update['user_password'] = $oldPassword;

        $update = InputValidation::inputsValidationProfileUpdate($update);

        var_dump($update);
        var_dump(Session::get('user_profile_info'));

        if(!$userGoodPassword = password_verify($update['user_password'], $this->userSQL->getUserPasswordHash(Session::get('user_profile_info')['user_name']))){
            $this->feedback->add('Wrong password',FEEDBACK_TYPE_FAIL);
        }

        if(Session::get('user_profile_info')['user_name']!= $update['user_name'] && $user_name_exist = $this->userSQL->exist($update['user_name']))
            $this->feedback->add('Username already exist.', FEEDBACK_TYPE_WARNING);
        if(Session::get('user_profile_info')['user_email']!= $update['user_email'] && $user_mail_exist = $this->userSQL->exist($update['user_email']))
            $this->feedback->add('Mail adress already exist.', FEEDBACK_TYPE_WARNING);

        if(!$update || $user_name_exist || $user_mail_exist | !$userGoodPassword)
            Url::redirect('authentifier/profileUpdateForm');
        else {
            if(Session::get('user_profile_info')['user_name'] != $update['user_name'])
                $updateUser['user_name'] = $update['user_name'];
            if(Session::get('user_profile_info')['user_email'] != $update['user_email'])
                $updateUser['user_email'] = $update['user_email'];
            if(isset($update['user_new_password']));
                $updateUser['user_password_hash'] = password_hash($update['user_new_password'],PASSWORD_DEFAULT);
            $this->userSQL->updateUserProfile($updateUser, $this->getUserInfo());
            $this->feedback->add('Account update succefull',FEEDBACK_TYPE_SUCCESS);
            Url::redirect();
        }

    }

}