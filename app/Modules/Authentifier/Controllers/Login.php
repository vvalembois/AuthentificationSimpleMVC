<?php
/**
 * User: deloffre
 * Date: 21/02/16
 * Time: 19:48
 */


namespace Modules\Authentifier\Controllers;

use Core\Router;
use Core\View;


class Login extends Authentifier
{

    public function routes(){
        Router::any('authentifier/loginForm', 'Modules\Authentifier\Controllers\Login@loginForm');
    }

    public function loginForm(){
        $data = [];
        View::renderTemplate('header',$data);
        View::renderModule('/Authentifier/Views/Login/login_form', $data);
        View::renderTemplate('footer',$data);
    }

}