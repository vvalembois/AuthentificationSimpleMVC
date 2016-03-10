<?php
/**
 * User: deloffre
 * Date: 21/02/16
 * Time: 19:50
 */
use Modules\Authentifier\Helpers\Feedback;
use Modules\Authentifier\Helpers\InputValidation;

namespace Modules\Authentifier\Controllers;


class Profile extends Authentifier
{

    public function __construct()
    {
        parent::__construct();
    }
    
    
    public function routes()
    {
        Router::any('modifier/profileForm', 'Modules\Authentifier\Controllers\Profiler@profileForm');
        Router::any('modifier/profileAction', 'Modules\Authentifier\Controllers\Profile@profileAction');
    }
    
    public function profileForm()
    {
        $data['user_name'] = Session::get('post')['user_name'];
        $data['user_password'] = Session::get('post')['user_password'];
        $data['user_mail'] = Session::get('post')['user_mail'];
       
       /*si on veut mettre un captcha lors de la modification
        $this->captcha = new RainCaptcha();
       $data['captcha_url'] = $this->captcha->getImage(); */
       
        View::renderTemplate('header');
        $this->feedback->render();
        View::renderModule('/Authentifier/Views/User/user_update', $data);
        View::renderTemplate('footer');
    }
    
    public function profileAction()
    {
        /*
            if ($usernameExist = $this->userSQL->exist($input_valids['user_name']) != null)
                 $this->feedback->add("Username already exists");
                 
            if ($mailExist = $this->userSQL->exist($input_valids['user_mail']) != null)
                    $this->feedback->add("Mail adress already in use");
            
            /* Vérification du captcha si on veut en mettre un 
            $captcha = new RainCaptcha();
            if (!$captcha_valid = $captcha->checkAnswer(Request::post('user_captcha')))
                $this->feedback->add("Captcha error");
            */
            
             /* Si l'inscription a échouée, on renvoie vers le formulaire*/
            if($this->feedback->get() > 0){
                Session::set('post', $_POST);
                header('Location: ' . DIR . 'modifier/profileForm');
            }
            else
                header('Location: ' . DIR);
        */
    }

}