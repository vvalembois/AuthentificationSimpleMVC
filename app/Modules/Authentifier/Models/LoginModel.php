<?php
/**
 * User: deloffre
 * Date: 03/03/16
 * Time: 11:20
 */

namespace Modules\Authentifier\Models;


use Core\Model;
use Helpers\Database;
use Helpers\Session;
use Modules\Authentifier\Controllers\User;

class LoginModel extends UserModelTest
{
    public static function userIsLoggedIn()
    {
        $user_id = Session::get('user_id');
        return self::checkLoginSession($user_id, Session::id());
    }

    public function connection(){
        Session::regenerate();
        $this->session_id = Session::id();
        Database::get()->update('users', array('session_id'=>$this->session_id), array('user_id' => $this->user_id));
    }

    public function loginFailed(){
        $this->user_failed_logins ++;
        Database::get()->update('users',array('user_failed_logins'=>$this->user_failed_logins),array('user_id' => $this->user_id));
    }

    public static function checkLoginSession($user_id, $session_id){
        $user = UserModelTest::findByUserID($user_id);
        return ($user ? $user->checkSessionId($session_id) : false);
    }
}