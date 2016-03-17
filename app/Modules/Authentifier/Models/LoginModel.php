<?php
/**
 * User: deloffre
 * Date: 03/03/16
 * Time: 11:20
 */

namespace Modules\Authentifier\Models;


use Core\Model;
use Helpers\Session;

class LoginModel extends Model
{
    public static function userIsLoggedIn()
    {
        // TODO vérifier que la user_session correspond dans la base de donnée
        return Session::get('user_logged_in');
    }

    public static function checkPassword($password, $user_id){
        return password_verify($password,UserModel::getUserPasswordHash($user_id));
    }
}