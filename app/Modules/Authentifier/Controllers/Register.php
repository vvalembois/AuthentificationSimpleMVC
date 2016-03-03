<?php
/**
 * User: deloffre
 * Date: 21/02/16
 * Time: 19:49
 */

namespace Modules\Authentifier\Controllers;


use Core\Router;
use Core\View;
use Modules\Authentifier\Models\RegisterModel;

class Register extends Authentifier
{
    public function routes(){
        Router::any('authentifier/login_register', 'Modules\Authentifier\Controllers\Register@login_register');
    }

    /**
     * Formulaire d'inscription d'un nouvel utilisateur
     */
    public function registerForm(){
        View::renderModule('/Authentifier/Views/Register/register_form');
    }

    /**
     * Action effectuée à la reception d'un formulaire d'inscription
     */
    public function registerAction(){
        $register_successful = RegisterModel::NewUser();
    }
}