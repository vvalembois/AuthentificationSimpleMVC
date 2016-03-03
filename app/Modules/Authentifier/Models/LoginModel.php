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
        return Session::get('user_logged_in');
    }
}