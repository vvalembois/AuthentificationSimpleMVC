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
            $update['user_password_hash'] = password_hash($newPassword,PASSWORD_DEFAULT);

        $update = InputValidation::inputsValidationProfileUpdate($update);

        if(!$update)
            Url::redirect('authentifier/profileUpdateForm');
        else {
            $this->userSQL->updateUserProfile($update, $this->getUserInfo());
            $this->feedback->add('Account update succefull',FEEDBACK_TYPE_SUCCESS);
            Url::redirect();
        }

    }

}